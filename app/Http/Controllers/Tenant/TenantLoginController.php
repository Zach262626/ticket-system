<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TenantLoginController extends Controller
{
    public function showLogin(Request $request)
    {
        return view("auth.tenant.login");
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255']
        ]);
        $username = Str::slug($validated['email'], '_'); // “gp5_gmailcom”
        try {
            $tenants = Tenant::All();

            $tenant = Tenant::where('tenancy_db_username', $username)->firstOrFail();
            if (Hash::check($validated['password'], $tenant->tenancy_db_password)) {
                throw new ModelNotFoundException;
            }
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(
                ['email' => 'These credentials do not match our records.']
            );
        }
        return redirect()->route('home');
    }
}
