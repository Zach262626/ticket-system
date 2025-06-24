<?php

declare(strict_types=1);

use App\Events\BroadcastTestAlways;
use App\Events\TicketCreated;
use App\Events\TicketDeleted;
use App\Events\TicketStatusChange;
use App\Events\TicketUpdated;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserSettingsController;
use App\Mail\TicketCreatedMail;
use App\Models\Ticket\Ticket;
use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        | User Settings Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/settings', [UserSettingsController::class, 'index'])->name('settings-index');
        Route::post('/settings/profile', action: [UserSettingsController::class, 'updateProfile'])->name('settings-profile-update');
        Route::post('/settings/profile/picture', action: [UserSettingsController::class, 'updateProfilePicture'])->name('settings-profile-picture-update');
        Route::post('/settings/profile/picture/delete', action: [UserSettingsController::class, 'deleteProfilePicture'])->name('settings-profile-picture-delete');
        Route::post('/settings/account', [UserSettingsController::class, 'deleteAccount'])->name('settings-account-delete');
        Route::post('/settings/notifications', [UserSettingsController::class, 'updateNotification'])->name('settings-notifications');

        /*
        |--------------------------------------------------------------------------
        | Ticket Routes
        |--------------------------------------------------------------------------
        */
        // !Temporary!
        Route::get('/test-email', function () {
            $ticket = Ticket::first();
            TicketCreated::dispatch($ticket->id, tenant()->id);
            TicketStatusChange::dispatch($ticket->id, tenant()->id);
            TicketUpdated::dispatch($ticket->id, tenant()->id);
            TicketDeleted::dispatch($ticket->load(['status', 'level', 'type', 'createdBy', 'acceptedBy'])->toArray(), tenant()->id);
            return redirect()->back();
        })->name('test-email');
        Route::get('/test-email-create', function () {
            $ticket = Ticket::first();
            return new App\Mail\TicketCreatedMail($ticket, '');
        })->name('test-email-create');
        // !Temporary!
        Route::get('/ticket', [TicketController::class, 'index'])->name('ticket-index');
        Route::get('/ticket/search', [TicketController::class, 'search'])->name('ticket-search');
        Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket-create')->middleware('permission:create tickets');


        Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket-show');
        Route::get('/ticket/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket-edit')->middleware('permission:edit tickets');
        Route::post('/ticket/{ticket}/assign', [TicketController::class, 'assign'])->name('ticket-assign')->middleware('permission:assign tickets');
        Route::post('/ticket/{ticket}/close', [TicketController::class, 'close'])->name('ticket-close')->middleware('permission:edit tickets');
        Route::post('/ticket', [TicketController::class, 'store'])->name('ticket-store')->middleware('permission:create tickets');
        Route::post('/ticket/{ticket}/update', [TicketController::class, 'update'])->name('ticket-update')->middleware('permission:edit tickets');
        Route::post('/ticket/{ticket}/delete', [TicketController::class, 'delete'])->name('ticket-delete')->middleware('permission:delete tickets');
        // Ticket Messages
        Route::post('/ticket/message', [MessageController::class, 'store'])->name('ticket-message-store');
        /*
        |--------------------------------------------------------------------------
        | Roles Routes
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => ['role_or_permission:assign roles']], function () {
            Route::get('admin/users/roles', [RoleController::class, 'index'])->name('users-roles');
            Route::post('admin/users/roles', [RoleController::class, 'assign'])->name('users-asign-roles');
        });
        Route::get('admin/roles', [RoleController::class, 'edit'])->name('edit-roles')->middleware('permission:edit roles');
        Route::post('admin/roles', [RoleController::class, 'update'])->name('update-roles')->middleware('permission:edit roles');
    });
});
