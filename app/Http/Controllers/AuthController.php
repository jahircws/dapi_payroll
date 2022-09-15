<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Suport\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');    
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ],
        [
            'email.exists' => 'This email does not exist.'
        ]);

        $creds = $request->only('email', 'password');

        if(Auth::guard('web')->attempt($creds)){
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->with('error', 'Invalid email/password. Try again.');
        }
    }

    function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'You have successfully logged out');
    }
}
