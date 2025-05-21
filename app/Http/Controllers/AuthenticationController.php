<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255']
        ]);
        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            "name" => ['required', 'max:255'],
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255', 'min:8']
        ]);
        $user = User::create($fields);
        Auth::login($user);
        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        // Handle the logout logic here
        return redirect()->route('home');
    }
    public function forgotPassword(Request $request)
    {
        // Handle the forgot password logic here
        return redirect()->route('home');
    }
    public function resetPassword(Request $request)
    {
        // Handle the reset password logic here
        return redirect()->route('home');
    }
    public function verifyEmail(Request $request)
    {
        // Handle the email verification logic here
        return redirect()->route('home');
    }
    public function resendVerificationEmail(Request $request)
    {
        // Handle the resend verification email logic here
        return redirect()->route('home');
    }
}
