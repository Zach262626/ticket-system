<?php

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\RegisterTenantRequest;
use App\Http\Requests\UpdateProfileRequest;

it('register user request contains expected rules', function () {
    $request = new RegisterUserRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKeys(['name', 'email', 'password', 'phone_number']);
});

it('register tenant request contains expected rules', function () {
    $request = new RegisterTenantRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKeys(['company_name', 'sub_domain', 'password', 'remember']);
});

it('update profile request contains expected rules', function () {
    $request = new UpdateProfileRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKeys(['name', 'email', 'password']);
});

