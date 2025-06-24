<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Avatar;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;


class RegisterController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(['auth'], except: ['register', 'showRegister']),

        ];
    }
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
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->syncRoles(Role::where('name', 'member')->get());
        if (! Auth::attempt($validated)) {
            return redirect('/login')->withErrors(['email' => 'Could not log you in.']);
        }
        // !Temporary! add a remember me functionality
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
