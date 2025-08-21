<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class PageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests
        if (!$request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Skip tracking for admin user or bots
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $response;
        }
        
        if ($this->isBot($request)) {
            return $response;
        }

        $this->trackPageView($request);


        return $response;
    }

    private function trackPageView(Request $request) {

        $blogId = $request->route('blog') ?? $request->route('id');

        if ($blogId) {
            // Find blog by ID or slug
            $blog = is_numeric($blogId) 
                ? Blog::find($blogId)
                : Blog::where('slug', $blogId)->first();
                
            if ($blog) {
                
                $route = $request->route();
                $routeName = $route ? $route->getName() : null;
                $url = $request->url();
                $ip = $request->ip();
                $userAgent = $request->userAgent();
                $referer = $request->header('referer');


                // Check if this is a blog blog view
                if ($routeName === 'blog.show' || str_contains($url, '/blog/')) {
                    $this->trackBlogPostView($request, $ip, $userAgent, $referer);

                }

                DB::table('page_views')->insert([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'referer' => $referer,
                    'user_id' => Auth::id(),
                    'blog_id' => $blog->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        

    }

    /**
     * Track blog blog views
     */
    private function trackBlogPostView(Request $request, $ip, $userAgent, $referer)
        {
        $blogId = $request->route('blog') ?? $request->route('id');
        
        if ($blogId) {
            // Find blog by ID or slug
            $blog = is_numeric($blogId) 
                ? Blog::find($blogId)
                : Blog::where('slug', $blogId)->first();
                
            if ($blog) {
                // Check if this IP has viewed this blog recently (within 24 hours)
                $recentView = DB::table('blog_views')
                    ->where('blog_id', $blog->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();
                
                if (!$recentView) {
                    // Increment blog view count
                    $blog->increment('views_count');
                    
                    // Record detailed view
                    DB::table('blog_views')->insert([
                        'blog_id' => $blog->id,
                        'ip_address' => $ip,
                        'user_agent' => $userAgent,
                        'referer' => $referer,
                        'user_id' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
    
    /**
     * Check if request is from a bot
     */
    private function isBot(Request $request)
    {
        $userAgent = strtolower($request->userAgent());
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 
            'baiduspider', 'yandexbot', 'facebookexternalhit',
            'twitterbot', 'rogerbot', 'linkedinbot', 'whatsapp',
            'crawler', 'spider', 'bot', 'scraper'
        ];
        
        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return true;
            }
        }
        
        return false;
    }
}
