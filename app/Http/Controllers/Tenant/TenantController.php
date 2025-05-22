<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function test()
    {
        $tenant = Tenant::create(
            [
                'id' => 'test' . uniqid(),
            ]
        );
        $tenant->domains()->create([
            'domain' => $tenant->id . '.localhost',
        ]);
        return redirect()->route('home');
    }
    public function showRegister(Request $request)
    {
        return view("auth.tenant.register");
    }
    public function showLogin(Request $request)
    {
        return view("auth.tenant.login");
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
