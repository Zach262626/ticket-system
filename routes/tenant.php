<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\TicketController;
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
    Route::get('/tenant/logout', [TenantController::class, 'logout'])->name('tenant-logout');
    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLogin'])->name('user-login');
        Route::post('login', [LoginController::class, 'login'])->name('user-login');
        Route::get('register', [RegisterController::class, 'showRegister'])->name('user-register');
        Route::post('register', [RegisterController::class, 'register'])->name('user-register');
    });
    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('user-logout');
        Route::get('/', [HomeController::class, 'index'])->name('home');
        /*
        |--------------------------------------------------------------------------
        | Ticket Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/ticket', [TicketController::class, 'index'])->name('ticket-index');
        Route::get('/ticket/create', [TicketController::class, 'showCreate'])->name('ticket-create');
        Route::get('/ticket/edit', [TicketController::class, 'showEdit'])->name('ticket-edit');
        Route::get('/ticket/show', [TicketController::class, 'show'])->name('ticket-show');
        Route::post('/ticket/create', [TicketController::class, 'create'])->name('ticket-create');
        Route::post('/ticket/edit', [TicketController::class, 'edit'])->name('ticket-edit');
        Route::post('/ticket/delete', [TicketController::class, 'delete'])->name('ticket-delete');
        Route::get('admin/users/roles', [RoleController::class, 'create'])
        /*
        |--------------------------------------------------------------------------
        | Roles Routes
        |--------------------------------------------------------------------------
        */
            ->name('users-roles');
        Route::post('admin/users/roles', [RoleController::class, 'store'])
            ->name('users-asign-roles');
    });
});
