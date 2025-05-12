<?php

use App\Events\EventBroadcastTest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    broadcast(new EventBroadcastTest());
    return redirect('/');
});
