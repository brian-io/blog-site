<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use App\Models\Vote;

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
        $request->merge(['user_id' => Auth::id()]);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
            'user_name' => 'required_without:user_id|string|max:255',
            'user_email' => 'required_without:user_id|email|max:255',
        ]);


        // Spam detection 
        if ($this->isSpam($validated['content'])) {
            return back()->withErrors(['content' => 'Spam Detected!']);
        }


        // Default status
        $status = Comment::STATUS_PENDING;

        if (Auth::check()){
            $user = Auth::user();

            if ($user->isAdmin() || ($user->isTrusted())) {
                $status = Comment::STATUS_APPROVED;
            }
        }
        // Map to database columns if different
        $commentData = [
            'content' => $validated['content'],
            'blog_id' => $blog->id, // Use blog_id instead of post_id
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status,
        ];
       
        // Add guest user data if not authenticated
        if (!Auth::check()) {
            $commentData['user_name'] = $validated['user_name'];
            $commentData['user_email'] = $validated['user_email'];
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

        return back()->with('success', $status === Comment::STATUS_APPROVED
        ? 'Comment submitted!'
        : 'Your comment is waiting moderation');
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
        
        if ($comment->replies()->count() > 0) {
            $comment->delete(); // Soft delete if has replies
        } else {
            $comment->forceDelete(); // Permanently delete if no replies
        }

        return back()->with('success', 'Comment deleted!');
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
