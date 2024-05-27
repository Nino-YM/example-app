<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(10);
        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'image' => 'image|nullable',
            'tags' => 'nullable'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Message::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
            'image' => $imagePath,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
        ]);

        return redirect()->route('messages.index');
    }

    public function edit(Message $message)
    {
        return view('messages.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $request->validate([
            'text' => 'required',
            'image' => 'image|nullable',
            'tags' => 'nullable'
        ]);

        $imagePath = $message->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $message->update([
            'text' => $request->text,
            'image' => $imagePath,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
        ]);

        return redirect()->route('messages.index');
    }

    public function destroy(Message $message)
    {
        if ($message->image) {
            Storage::disk('public')->delete($message->image);
        }
        $message->delete();
        return redirect()->route('messages.index');
    }
}
