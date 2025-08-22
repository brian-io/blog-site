<?php
// app/Http/Controllers/Admin/CommentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
       return [
            new Middleware('auth'),
            new Middleware('can:manage-comments')
        ];
    }

    public function index(Request $request)
    {
        $query = Comment::with(['blog:id,title,slug', 'user:id,name,email'])
                       ->withSum('votes', 'vote') // Include vote scores
                       ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by blog
        if ($request->filled('blog_id')) {
            $query->where('blog_id', $request->blog_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $comments = $query->paginate(15)->withQueryString();
        
        // Get counts for status tabs
        $statusCounts = [
            'all' => Comment::count(),
            'pending' => Comment::where('status', Comment::STATUS_PENDING)->count(),
            'approved' => Comment::where('status', Comment::STATUS_APPROVED)->count(),
            'rejected' => Comment::where('status', Comment::STATUS_REJECTED)->count(),
            'spam' => Comment::where('status', Comment::STATUS_SPAM)->count(),
        ];

        return view('admin.comments.index', compact('comments', 'statusCounts'));
    }

    public function show(Comment $comment)
    {
        $comment->load([
            'blog:id,title,slug',
            'user:id,name,email,avatar',
            'parent.user:id,name',
            'replies.user:id,name',
            'votes.user:id,name'
        ]);

        return view('admin.comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        $comment->update(['status' => Comment::STATUS_APPROVED]);
        
        // Increment user trust score if user exists
        if ($comment->user && $comment->user->comment_trust_score < User::TRUSTED_COMMENT_THRESHOLD * 2) {
            $comment->user->incrementTrustScore();
        }
        
        // Log activity
        UserActivity::log(
            UserActivity::ACTION_COMMENT_APPROVED,
            'Approved comment by: ' . $comment->getAuthorDisplayName(),
            $comment
        );
        
        return back()->with('success', 'Comment approved successfully!');
    }

    public function reject(Comment $comment)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        $comment->update(['status' => Comment::STATUS_REJECTED]);
        
        // Log activity
        UserActivity::log(
            UserActivity::ACTION_COMMENT_REJECTED,
            'Rejected comment by: ' . $comment->getAuthorDisplayName(),
            $comment
        );
        
        return back()->with('success', 'Comment rejected successfully!');
    }

    public function markAsSpam(Comment $comment)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        $comment->update(['status' => Comment::STATUS_SPAM]);
        
        // Log activity
        UserActivity::log(
            UserActivity::ACTION_COMMENT_MARKED_SPAM,
            'Marked comment as spam by: ' . $comment->getAuthorDisplayName(),
            $comment
        );
        
        return back()->with('success', 'Comment marked as spam successfully!');
    }

    public function restore(Comment $comment)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        // Restore soft deleted comment
        $comment->restore();
        
        // Log activity
        UserActivity::log(
            UserActivity::ACTION_COMMENT_RESTORED,
            'Restored comment by: ' . $comment->getAuthorDisplayName(),
            $comment
        );
        
        return back()->with('success', 'Comment restored successfully!');
    }

    public function destroy(Comment $comment)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        // Log activity before deletion
        UserActivity::log(
            UserActivity::ACTION_COMMENT_DELETED,
            'Deleted comment by: ' . $comment->getAuthorDisplayName(),
            $comment
        );
        
        // Check if comment has replies
        if ($comment->replies()->count() > 0) {
            // Soft delete to preserve thread structure
            $comment->delete();
            $message = 'Comment soft deleted (has replies) successfully!';
        } else {
            // Permanently delete if no replies
            $comment->forceDelete();
            $message = 'Comment permanently deleted successfully!';
        }
        
        return back()->with('success', $message);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,spam,delete',
            'comment_ids' => 'required|array|min:1',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        $commentIds = $request->comment_ids;
        $action = $request->action;
        $count = 0;

        foreach ($commentIds as $commentId) {
            $comment = Comment::find($commentId);
            if (!$comment) continue;

            switch ($action) {
                case 'approve':
                    if ($comment->status !== Comment::STATUS_APPROVED) {
                        $comment->update(['status' => Comment::STATUS_APPROVED]);
                        if ($comment->user) {
                            $comment->user->incrementTrustScore();
                        }
                        $count++;
                    }
                    break;
                    
                case 'reject':
                    if ($comment->status !== Comment::STATUS_REJECTED) {
                        $comment->update(['status' => Comment::STATUS_REJECTED]);
                        $count++;
                    }
                    break;
                    
                case 'spam':
                    if ($comment->status !== Comment::STATUS_SPAM) {
                        $comment->update(['status' => Comment::STATUS_SPAM]);
                        $count++;
                    }
                    break;
                    
                case 'delete':
                    if ($comment->replies()->count() > 0) {
                        $comment->delete(); // Soft delete
                    } else {
                        $comment->forceDelete(); // Permanent delete
                    }
                    $count++;
                    break;
            }
        }

        $actionText = ucfirst($action) . ($action === 'delete' ? 'd' : 'd');
        return back()->with('success', "{$count} comment(s) {$actionText} successfully!");
    }

    public function export(Request $request)
    {
        // Check authorization
        Gate::authorize('manage-comments');
        
        $query = Comment::with(['blog:id,title', 'user:id,name,email']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('blog_id')) {
            $query->where('blog_id', $request->blog_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        $comments = $query->get();

        $csv = "ID,Blog,Author,Email,Content,Status,Created At,IP Address\n";
        
        foreach ($comments as $comment) {
            $csv .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $comment->id,
                $comment->blog->title ?? 'Unknown',
                $comment->getAuthorDisplayName(),
                $comment->user?->email ?? $comment->user_email ?? '',
                str_replace('"', '""', $comment->content),
                $comment->status,
                $comment->created_at->format('Y-m-d H:i:s'),
                $comment->ip_address ?? ''
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="comments_' . date('Y-m-d') . '.csv"');
    }
}