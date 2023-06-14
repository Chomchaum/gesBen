<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanctumAuthController extends Controller
{
    /**
     * Fonction d'authentification
     * username -> email
     */

    public function login(LoginRequest $request)
    {
        $email = $request->input('username');
        $password = $request->input('password');
        $user = false;

        if (User::whereEmail($email)->exists()) {
            $user = User::whereEmail($email)->first();
        } else {
            abort(404);
        }

        $credentials = ['email' => $user->getRawOriginal('email'), 'password' => $password];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response(['success' => auth()->user()]);
        } else {
            return response(['success' => false], 404);
        }
    }

    public function register(CreateUserRequest $request)
    {
        $user = User::create([
          'firstname' => $request->input('firstname'),
          'lastname' => $request->input('lastname'),
          'email' => $request->input('email'),
          'password' => $request->input('password'),
        ]);

        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        if (Auth::attempt($credentials)) {
            return response(['user_id' => auth()->user()->id]);
        } else {
            return response(['success' => false], 404);
        }
    }

    public function logout(Request $request)
    {
        dump('OUT');

        Auth::logout();
    }
}
