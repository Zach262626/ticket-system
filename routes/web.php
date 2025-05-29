<?php

use App\Events\EventBroadcastTest;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\Tenant\TenantHomeController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;








foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/login', [LoginController::class, 'showLogin'])->name('user-login');
            Route::post('/login', [LoginController::class, 'login'])->name('user-login');
            Route::get('/register', [RegisterController::class, 'showRegister'])->name('user-register');
            Route::post('/register', [RegisterController::class, 'register'])->name('user-register');
        });
        /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
        Route::middleware('auth')->group(function () {
            Route::get('logout', [LoginController::class, 'logout'])->name('user-logout');
            /*
        |--------------------------------------------------------------------------
        | Tenant Routes
        |--------------------------------------------------------------------------
        */
            Route::group(['middleware' => ['role:developer']], function () {
                Route::get('/', [TenantHomeController::class, 'index'])->name('home');
                Route::get('/tenant/register', [TenantController::class, 'showRegister'])->name('tenant-register');
                Route::post('/tenant/register', [TenantController::class, 'register'])->name('tenant-register');
                Route::post('/tenant/login', [TenantController::class, 'login'])->name('tenant-login');
                Route::get('admin/users/roles', [RoleController::class, 'create'])->name('users-roles');
                Route::post('admin/users/roles', [RoleController::class, 'store'])->name('users-asign-roles');
            });
        });
    });
}
