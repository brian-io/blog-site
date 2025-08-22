<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class RateLimitComments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply rate limiting to comment submissions
        if(!$request->isMethod('POST') || !$request->has('comment')){
            return $next($request);
        }

        // Get identifier (user ID or IP address)
        $identifier = Auth::check()
            ? 'user_'. Auth::id()
            : 'ip_' . $request->ip();

        $cacheKey = "comment_rate_limit_{$identifier}";

        // Get Current attempt count
        $attempts = Cache::get($cacheKey, 0);

        $maxAttempts = Auth::check() ? 10 : 3; // Authenticated users get higher limit
        $decayMinutes = 60; // Reset counter every hour

        if ($attempts >= $maxAttempts) {
            $remainingTime = Cache::get($cacheKey . '_expires', now()->addMinutes($decayMinutes));
            $minutesLeft = now()->diffInMinutes($remainingTime);

            return back()->withErrors([
                'comment' => "Too many comment attempts. Please wait {$minutesLeft} minutes before trying again."
            ]);
        }

        // Increment attempt counter
        Cache::put($cacheKey, $attempts + 1, now()->addMinutes($decayMinutes));
        Cache::put($cacheKey . '_expires', now()->addMinutes($decayMinutes), now()->addMinutes($decayMinutes));
        
        $response = $next($request);
        
        // Add rate limit headers
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', max(0, $maxAttempts - $attempts - 1));
        
        return $response;
    }
}
