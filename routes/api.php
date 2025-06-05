<?php

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');
Route::middleware('auth')->get('/tickets/{ticket}/messages', function (Request $request, Ticket $ticket) {
    return response()->json($ticket->messages()->with('sender')->get());
});