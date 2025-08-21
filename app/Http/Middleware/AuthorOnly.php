<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class AuthorOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()){
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Get post ID from route parameters
        $blogId = $request->route('post') ?? $request->route('id');

        if ($blogId) {
            $blog = Blog::find($blogId);

            if (!$blog) {
                abort(404, "Post not found.");
            }
        }

        if (!$user->isAdmin() && $blog->user_id !== $user->id) {
            abort(403, 'Not authorized');
        }
        return $next($request);
    }
}
