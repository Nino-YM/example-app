<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
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
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('content', 'LIKE', "%$query%")
                     ->orWhere('tags', 'LIKE', "%$query%")
                     ->paginate(10);

        return view('posts.searchresults', compact('posts', 'query'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

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
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index');
    }
}
