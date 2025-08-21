<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class DraftAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $blogId = $request->route('post') ?? $request->route('id');

        if ($blogId) {
            $blog = Blog::find($blogId);

            if (!$blog) {
                abort(404, 'Blog post not found');
            }

            // if blog post is a draft
            if ($blog->status === 'draft') {
                // Allow access if user is authenticated and is either admin or author
                if (!Auth::check()) {
                    abort(404, "Blog post not found");
                }

                $user = Auth::user();
                if (!$user->isAdmin() && $blog->user_id !== $user->id) {
                    abort(404, "Blog post not found.");
                }
            }
        }
        return $next($request);
    }
}
