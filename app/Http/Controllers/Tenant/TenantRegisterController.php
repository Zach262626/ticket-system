<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantRegisterController extends Controller
{
    public function test()
    {
        $tenant = Tenant::create(
            [
                'name' => 'test' . uniqid(),
            ]
        );
        $tenant->domains()->create([
            'domain' => $tenant->name . '.localhost',
        ]);
        return redirect()->route('home');
    }
    public function showRegister(Request $request)
    {
        return view("auth.tenant.register");
    }
    public function register(RegisterTenantRequest $request)
    {
        $validated = $request->validated();
        $username  = Str::slug($validated['email'], '_'); // “gp5_gmail_com”
        $tenant    = Tenant::create(
            [
                'name'                => $validated['sub_domain'],
                'tenancy_db_username' => $username,
                'tenancy_db_password' => $validated['password'],
            ]
        );
        $tenant->domains()->create([
            'domain' => $validated['sub_domain'] . '.localhost',
        ]);
        // $tenant->createDatabase();
        // $tenant->createDatabaseUser();
        return redirect($validated['sub_domain'] . '.localhost:2000/login');
    }
}
