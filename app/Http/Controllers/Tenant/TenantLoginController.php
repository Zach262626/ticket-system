<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantLoginController extends Controller
{
    public function showLogin(Request $request)
    {
        return view("auth.tenant.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255']
        ]);
        return redirect()->route('home');
    }
}
