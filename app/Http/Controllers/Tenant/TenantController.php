<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
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
    
        $tenant    = Tenant::create(
            [
                'name'                => $validated['sub_domain'],
                'tenancy_db_username' => $validated['email'],
                'tenancy_db_password' => $validated['password'],
            ]
        );
        $domain = $tenant->domains()->create([
            'domain' => $validated['sub_domain'] . '.localhost',
        ]);
        $request->session()->put('tenant_id', $request->tenant_id);
        $request->session()->put('tenant_domain', $request->tenant_domain);
        return redirect()->away('http://' . $domain->domain . ":" . env('APP_PORT', '80'));
    }
    public function login(Request $request)
    {
        $tenant = Tenant::where('id', $request->tenant_id)
            ->firstOrFail();
        $request->session()->put('tenant_id', $request->tenant_id);
        $request->session()->put('tenant_domain', $tenant->domains()->first()->domain);
        return redirect()->away('http://' . $tenant->domains()->first()->domain . ":" . env('APP_PORT', '80'));
    }
    public function logout(Request $request)
    {
        $request->session()->forget('tenant_id');
        $request->session()->forget('tenant_domain');
        return redirect()->away(env('APP_URL', 'localhost'). ":" . env('APP_PORT', '80'));
    }
}
