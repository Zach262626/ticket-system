<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Restrict access to users with the 'admin' or 'developer' role.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|developer'),
        ];
    }
    /**
     * Display the role assignment form with all users and roles.
     */
    public function create()
    {
        return view('roles.assign-user', [
            'users' => User::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }
    /**
     * Validate input and synchronize the selected role onto the user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id'   => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $roles = Role::findOrFail($request->role_id);
        $user->syncRoles($roles);

        return redirect()->back()
            ->with('success', 'Roles updated for ' . $user->name);
    }
}
