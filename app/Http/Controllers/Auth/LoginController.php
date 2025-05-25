<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * show login page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function showLogin(Request $request)
    {
        return view("auth.user.login");
    }
    public function login(Request $request)
    {
        $request->validate([
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255']
        ]);
        try {
            $user = User::where('email', $request['email'])->firstOrFail();
            
            if (Hash::check($request['password'], $user['password'])) {
                throw new ModelNotFoundException;
            }
            Auth::login($user);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(
                ['email' => 'These credentials do not match our records.']
            );
        }

        
        return redirect()->route('home');
    }

    /**
     * Logout the user and redirect to home page.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    }
}
