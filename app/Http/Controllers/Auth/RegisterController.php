<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
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
        return view("auth.user.register");
    }
    /**
     * register the user and login.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        Auth::login($user);
        return redirect()->route('home');
    }
}
