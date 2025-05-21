<?php

use App\Events\EventBroadcastTest;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', function () {
            return view('home');
        });

        Route::get('/test', function () {
            broadcast(new EventBroadcastTest());
            return redirect('/');
        });
        Route::get('/login', function () {
            return view('auth.login');
        })->name('login');
        Route::get('/register', function () {
            return view('auth.register');
        })->name('register');
    });
}
