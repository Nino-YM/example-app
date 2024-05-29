<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
                'pseudo' => 'required|max:40',
                'image' => 'nullable||image',
            ]);
            $user->update($request->all());
            return back()->with('message', 'Le compte a bien été modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
    // on vérifie que c'est bien l'utilisateur connecté qui fait la demande de suppression
    // (les id doivent être identiques)
    if (Auth::user()->id == $user->id) {
        $user->delete();
        return redirect()->route('home')->with('message', 'Le compte a bien été supprimé');
    } else {
    return redirect()->back()->withErrors(['erreur' => 'Suppression du compte impossible']);
    }
    }
}
