<?php

use App\Events\EventBroadcastTest;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/test', function () {
            broadcast(new EventBroadcastTest());
            return redirect('/');
        });
        Route::get('/login', function () {
            broadcast(new EventBroadcastTest());
            return redirect('/');
        })->name('login');
        Route::get('/register', function () {
            broadcast(new EventBroadcastTest());
            return redirect('/');
        })->name('register');
    });
}
