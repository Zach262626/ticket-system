<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Tenant\TenantController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;




/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    ScopeSessions::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('user-login');
    Route::get('register', [RegisterController::class, 'showRegister'])->name('user-register');
    Route::post('login', [LoginController::class, 'login'])->name('user-login');
    Route::post('register', [RegisterController::class, 'register'])->name('user-register');
    Route::get('logout', [LoginController::class, 'logout'])->name('user-logout')->middleware('auth');
    Route::get('/tenant/logout', [TenantController::class, 'logout'])->name('tenant-logout');

    Route::get('/', function () {
        return view('home')->with(['tenant_id' => tenant('id'), 'tenant_name' => tenant('name')]);
    })->name('home');
});
