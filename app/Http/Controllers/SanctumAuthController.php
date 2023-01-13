<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request;

class SanctumAuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = false;
    }
}