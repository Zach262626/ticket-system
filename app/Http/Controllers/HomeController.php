<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

class HomeController extends Controller implements HasMiddleware
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
            ], only: ['indexTenant']),
        ];
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home')->with(['tenant_id' => tenant('id'), 'tenant_name' => tenant('name')]);
    }
}
