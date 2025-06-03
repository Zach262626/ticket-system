<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware([
                'web',
                InitializeTenancyByDomain::class,
                ScopeSessions::class,
                PreventAccessFromCentralDomains::class,
            ]),
            new Middleware('permission:edit roles', only: ['edit', 'update']),
            new Middleware('permission:delete roles', only: ['delete']),
            new Middleware('permission:create roles', only: ['create', 'store']),
            new Middleware('permission:assign roles', only: ['assign']),
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
    /**
     * Show all roles with their permission, allow to change role permission
     */
    public function edit(Request $request)
    {
        return view('roles.show-all', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }
    /**
     * update all roles with their permission, allow to change role permission
     */
    public function update(Request $request)
    {
        $inputPermissions = $request->input('permissions', []);

        foreach (Role::all() as $role) {
            $permissionIds = isset($inputPermissions[$role->id]) ? $inputPermissions[$role->id] : [];
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
