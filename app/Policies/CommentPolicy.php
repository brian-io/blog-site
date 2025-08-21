<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Comment $comment): bool
    {
        // Approved comments can be viewed by anyone
        if ($comment->isApproved()) {
            return true;
        }

        // Pending/rejected comments can only be viewed by author, blog author, or admins
        return $user && (
            $user->id === $comment->user_id ||
            $user->id === $comment->blog->user_id ||
            $user->isAdmin()
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return true; // Anyone can create comments (including guests)
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        // Only the comment author can update their own comment
        return $user->id === $comment->user_id;   
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id ||
               $user->id === $comment->blog->user_id ||
               $user->isAdmin();
    }
    /**
     * Determine whether the user can moderate comments (approve/reject).
     */
    public function moderate(User $user, Comment $comment): bool
    {
        return $user->id === $comment->blog->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can manage comments.
     */
    public function manageComments(User $user): bool
    {
        return $user->isAdmin();
    }
}
