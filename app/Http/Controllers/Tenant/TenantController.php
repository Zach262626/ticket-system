<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class TenantController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware([
                InitializeTenancyByDomain::class,
                ScopeSessions::class,
                PreventAccessFromCentralDomains::class,
            ], only: ['logout']),
        ];
    }

    public function showRegister(Request $request)
    {
        return view("auth.tenant.register");
    }

    public function register(RegisterTenantRequest $request)
    {
        $validated = $request->validated();
        if (Domain::where('domain', $validated['sub_domain'] . '.localhost')->exists()) {
            return redirect()->back()->withErrors(['sub_domain' => 'This subdomain is already taken.']);
        }
        $tenant    = Tenant::create(
            [
                'name'                => $validated['company_name'],
                'tenancy_db_username' => $validated['sub_domain'],
                'tenancy_db_password' => $validated['password'],
            ]
        );
        $domain = $tenant->domains()->create([
            'domain' => $validated['sub_domain'] . '.localhost',
        ]);
        $request->session()->put('tenant_id', $request->tenant_id);
        $request->session()->put('tenant_domain', $request->tenant_domain);
        return redirect(tenant_route($tenant->domains()->first()->domain, 'home'));
    }
    public function login(Request $request)
    {
        $tenant = Tenant::where('id', $request->tenant_id)
            ->firstOrFail();
        $request->session()->put('tenant_id', $request->tenant_id);
        $request->session()->put('tenant_domain', $tenant->domains()->first()->domain);
        return redirect(tenant_route($tenant->domains()->first()->domain, 'home'));
    }
    public function logout(Request $request)
    {
        $request->session()->forget('tenant_id');
        $domain = $request->session()->get('tenant_domain', 'localhost');
        $request->session()->forget('tenant_domain');
        return redirect(tenant_route($domain, 'home'));
    }
}
