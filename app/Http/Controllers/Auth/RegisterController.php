<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pseudo' => ['required', 'string', 'max:40', 'unique:users'],
            'image' => ['required', 'image', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $imagePath = request()->file('image')->store('images', 'public');

        return User::create([
            'pseudo' => $data['pseudo'],
            'image' => $imagePath,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
