<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            "name" => ['required', 'max:255'],
            "email" => ['required', 'max:255', 'email'],
            "password" => ['required', 'max:255', 'min:8']
        ]);
        $user = User::create($fields);
        Auth::login($user);
        return redirect()->route('home');
    }
}
