<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


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
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login')->name('user-login');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register')->name('user-register');
    Route::post('/login', [LoginController::class, 'login'])->name('login')->name('user-login');
    Route::post('/register', [RegisterController::class, 'register'])->name('register')->name('user-register');

    Route::get('/', function () {
        return view('welcome')->with(['tenant_id' => tenant('id'),]);
    });
});
