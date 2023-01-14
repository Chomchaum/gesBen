<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class SanctumAuthController extends Controller
{
    /**
     * Fonction d'authentification
     * username -> email
     */

    public function login(LoginRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = false;

        if (User::whereEmail($username)->exists()) {
            $user = User::whereEmail($username)->first();
        } else {
            abort(404);
        }

        $credentials = ['email' => $user->getRawOriginal('email'), 'password' => $password];
        if (Auth::attempt($credentials)) {
//            $request->session()->regenerate();
            session()->regenerate();
            return response(['success' => auth()->user()->id]);
        } else {
            return response(['success' => false], 404);
        }
    }

    public function register(RegisterRequest $request)
    {
        dump("plop");

        $user = User::create([
          'name' => $request->input('name'),
          'email' => $request->input('email'),
          'password' => $request->input('password')
        ]);

        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response(['success' => auth()->user()->id]);
        } else {
            return response(['success' => false], 404);
        }
    }
}