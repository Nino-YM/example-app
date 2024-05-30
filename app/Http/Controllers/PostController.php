<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'image' => 'image|nullable',
            'tags' => 'nullable'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image' => $imagePath,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
        ]);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required',
            'image' => 'image|nullable',
            'tags' => 'nullable'
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post->update([
            'content' => $request->content,
            'image' => $imagePath,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id && Auth::user()->role_id !== 2) {
            abort(403, 'Unauthorized action.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index');
    }
}
