<?php
namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can update the comment.
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->role_id === 2;
    }

    /**
     * Determine whether the user can delete the comment.
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->role_id === 2 || $user->id === $comment->post->user_id;
    }
}
