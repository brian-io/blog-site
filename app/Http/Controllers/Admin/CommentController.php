<?php
// app/Http/Controllers/Admin/CommentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class CommentController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
       return [
            new Middleware('auth'),
            new Middleware('can:manage-comments')
        ];
    }

    public function index(Request $request)
    {
        $query = Comment::with(['blog', 'user'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $comments = $query->paginate(10);
        
        // Get counts for tabs
        $pendingCount = Comment::where('status', Comment::STATUS_PENDING)->count();

        return view('admin.comments.index', compact('comments', 'pendingCount'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => Comment::STATUS_APPROVED]);
        
        return back()->with('success', 'Comment approved successfully!');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => Comment::STATUS_REJECTED]);
        
        return back()->with('success', 'Comment rejected successfully!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return back()->with('success', 'Comment deleted successfully!');
    }
}