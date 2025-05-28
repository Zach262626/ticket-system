<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create()
    {
        return view('roles.assign-user', [
            'users' => User::orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

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
