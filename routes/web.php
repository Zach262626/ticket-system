<?php

use App\Events\EventBroadcastTest;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\Tenant\TenantLoginController;
use App\Http\Controllers\Tenant\TenantRegisterController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;




foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/register', [TenantRegisterController::class, 'showRegister'])->name('tenant-register');
        Route::get('/login', [TenantLoginController::class, 'showLogin'])->name('tenant-login');
        Route::post('/register', [TenantRegisterController::class, 'register'])->name('tenant-register');
        Route::post('/login', [TenantLoginController::class, 'login'])->name('tenant-login');

        Route::get('/create-test', [TenantRegisterController::class, 'test'])->name('user.test');
    });
}
