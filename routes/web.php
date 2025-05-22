<?php

use App\Events\EventBroadcastTest;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tenant\TenantController;
use Illuminate\Support\Facades\Route;


foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/register', [TenantController::class, 'showRegister'])->name('tenant-register');
        Route::get('/login', [TenantController::class, 'showLogin'])->name('tenant-login');
        Route::post('/register', [TenantController::class, 'register'])->name('tenant-register');
        Route::post('/login', [TenantController::class, 'login'])->name('tenant-login');
    });
}
