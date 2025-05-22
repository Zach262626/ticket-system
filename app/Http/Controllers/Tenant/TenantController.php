<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function showRegister(Request $request)
    {
        return view("tenant.register");
    }
    public function showLogin(Request $request)
    {
        return view("tenant.login");
    }
    public function register(Request $request)
    {
        $fields = $request->validate([
            "company_name" => ['required', 'max:255'],
            "sub_domain" => ['required', 'max:255'],
            "email" => ['required', 'max:255', 'email'],
            "password" => ['comfirmation', 'required', 'max:255', 'min:8'],
        ]);
        return redirect()->route('home');
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
