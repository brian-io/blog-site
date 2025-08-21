<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Blog;
class BlogExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        $blogIdentifier = $request->route('post') ?? $request->route('slug') ?? $request->route('id');

        if ($blogIdentifier) {
            // Try to find by ID first, then by slug
            $blog = is_numeric($blogIdentifier)
                ? Blog::find($blogIdentifier)
                : Blog::where('slug', $blogIdentifier)->first();
        
            if (!$blog) {
                abort(404, 'The requested blog post could not be found.');
            }

            // Add blog post to request for use in controller
            $request->merge(['blog_model' => $blog]);
        }
        
        return $next($request);
    }
}
