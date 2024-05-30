<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'pseudo' => 'required|max:40',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $imagePath;
        }

        $user->pseudo = $request->pseudo;
        $user->save();

        return back()->with('message', 'Le compte a bien été modifié.');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id == $user->id) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->delete();
            return redirect()->route('home')->with('message', 'Le compte a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'Suppression du compte impossible']);
        }
    }
}
