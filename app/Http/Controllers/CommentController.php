<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back();
    }

    public function edit(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();
        return back();
    }
}
