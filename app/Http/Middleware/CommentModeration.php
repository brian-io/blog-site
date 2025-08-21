<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CommentModeration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If this is a comment submission
        if ($request->isMethod('POST') && $request->has('comment')) {
            $comment = $request->input('comment');
            
            // Check for spam patterns
            if ($this->isSpam($comment)) {
                return back()->withErrors(['comment' => 'Your comment appears to be spam.']);
            }
            
            // Auto-approve comments from authenticated users or admins
            if (Auth::check()) {
                $user = Auth::user();
                $request->merge(['approved' => $user->isAdmin() ? true : false]);
            } else {
                // Guest comments need moderation
                $request->merge(['approved' => false]);
            }
        }

        return $next($request);
    }
    
    /**
     * Simple spam detection
     */
    private function isSpam($comment)
    {
        $spamKeywords = [
            'buy now', 'click here', 'free money', 'guaranteed', 
            'make money', 'no obligation', 'risk free', 'viagra',
            'casino', 'poker', 'lottery', 'winner'
        ];
        
        $comment = strtolower($comment);
        
        foreach ($spamKeywords as $keyword) {
            if (str_contains($comment, $keyword)) {
                return true;
            }
        }
        
        // Check for excessive links
        $linkCount = substr_count($comment, 'http');
        if ($linkCount > 2) {
            return true;
        }
        
        return false;
    }
}

