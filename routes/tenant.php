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
        // !Temporary!
        Route::get('/ticket/factory', function () {
            App\Models\Ticket\Ticket::factory()->count(300)->create(['created_by' => 1, 'accepted_by' => 1]);
            return back();
        })->middleware('role:developer');
        Route::get('/ticket', [TicketController::class, 'index'])->name('ticket-index');
        Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket-create')->middleware('permission:create tickets');
        Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket-show');
        Route::get('/ticket/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket-edit')->middleware('permission:edit tickets');
        Route::post('/ticket', [TicketController::class, 'store'])->name('ticket-store')->middleware('permission:create tickets');
        Route::post('/ticket/{ticket}/update', [TicketController::class, 'update'])->name('ticket-update')->middleware('permission:edit tickets');
        Route::post('/ticket//{ticket}/delete', [TicketController::class, 'delete'])->name('ticket-delete')->middleware('permission:delete tickets');
        /*
        |--------------------------------------------------------------------------
        | Roles Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => ['role_or_permission:assign roles']], function () {
            Route::get('admin/users/roles', [RoleController::class, 'create'])->name('users-roles');
            Route::post('admin/users/roles', [RoleController::class, 'store'])->name('users-asign-roles');
        });
    });
});
