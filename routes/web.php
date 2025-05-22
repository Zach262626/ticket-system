<?php

use App\Events\EventBroadcastTest;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');
    });
}
