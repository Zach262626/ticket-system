<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class LoginController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [

            InitializeTenancyByDomain::class,
            ScopeSessions::class,
            PreventAccessFromCentralDomains::class,
            new Middleware(['auth'], except: ['login', 'showLogin']),

        ];
    }
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
        $validated = $request->validate([
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255']
        ]);
        $remember = $request->validate([
            "remember" => ['boolean', 'nullable']
        ]);
        if (! Auth::attempt($validated, $remember['remember'] ?? false)) {
            return redirect()->back()->withErrors(['email' => 'The provided credentials are incorrect.']);
        }

        $request->session()->regenerate();


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
