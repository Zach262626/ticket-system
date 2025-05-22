<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * return the view for the register page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegister(Request $request)
    {
        return view("auth.user.login");
    }
    /**
     * register the user and login.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
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
}
