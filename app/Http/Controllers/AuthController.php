<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($validated)) {
            return redirect('/')->with('message', 'Login Successful');
        }

        return back()->with('message', 'Invalid username or password');
    }

    public function logout() {
        auth()->logout();
        
        return redirect('/login')->with('message', 'Logout Successful');
    }
}
