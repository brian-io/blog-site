<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['store']),
        ];
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {
        $validated = $request->validate([
        'content' => 'required|string|max:1000',
        'parent_id' => 'nullable|exists:comments,id',
        // Match the form field names
        'name' => 'required_without:user_id|string|max:255',
        'email' => 'required_without:user_id|email|max:255',
        ]);

        // Map to database columns if different
        $commentData = [
            'content' => $validated['content'],
            'blog_id' => $blog->id, // Use blog_id instead of post_id
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => Comment::STATUS_PENDING,
        ];
       
        // Add guest user data if not authenticated
        if (!Auth::check()) {
            $commentData['name'] = $validated['name'];
            $commentData['email'] = $validated['email'];
        }

        // Add parent_id if this is a reply
        if (isset($validated['parent_id'])) {
            $commentData['parent_id'] = $validated['parent_id'];
        }

        $comment = Comment::create($commentData);

        if (Auth::check()) {
            UserActivity::log(
                UserActivity::ACTION_COMMENT_CREATED,
                'Created comment on blog: ' . $blog->title,
                $comment
            );
        }

        return back()->with('success', 'Comment submitted!');
    }

    public function approve(Comment $comment)
    {
        Gate::authorize('moderate', $comment);
        
        $comment->update(['status' => Comment::STATUS_APPROVED]);

        UserActivity::log(
            UserActivity::ACTION_COMMENT_APPROVED,
            'Approved comment by: ' . $comment->getAuthorDisplayName(),
            $comment
        );

        return back()->with('success', 'Comment approved!');
    }

    public function reject(Comment $comment)
    {
        Gate::authorize('moderate', $comment);
        
        $comment->update(['status' => Comment::STATUS_REJECTED]);

        return back()->with('success', 'Comment rejected!');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        
        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}
