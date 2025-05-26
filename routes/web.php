<?php

use App\Events\EventBroadcastTest;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Tenant\TenantController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;




foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/register', [TenantController::class, 'showRegister'])->name('tenant-register');
        Route::post('/register', [TenantController::class, 'register'])->name('tenant-register');
        Route::get('/login', [TenantController::class, 'login'])->name('tenant-login');


        Route::get('/create-test', [TenantController::class, 'test'])->name('user.test');
    });
}
