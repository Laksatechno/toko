<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors('Login failed. Please check your credentials.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
