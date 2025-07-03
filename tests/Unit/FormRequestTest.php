<?php

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\RegisterTenantRequest;
use App\Http\Requests\UpdateProfileRequest;
use Stancl\Tenancy\Facades\Tenancy;
use App\Models\Tenant;

beforeEach(function () {
    $this->tenant    = Tenant::create(
        [
            'id' => fake()->unique()->randomNumber(),
            'name'                => 'Test Company',
            'tenancy_db_username' => 'testDomain' . fake()->unique()->randomNumber(),
            'tenancy_db_password' => '12345678',
        ]
    );
    $this->domain = $this->tenant->domains()->create([
        'domain' => 'testDomain.localhost',
    ]);
    Tenancy::initialize(tenant: $this->tenant);
});
afterEach(function () {
    Tenancy::end();

    if ($this->tenant) {
        $this->tenant->delete();
    }
});
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
    $user = \App\Models\User::factory()->make(['id' => 1]);

    $request = new UpdateProfileRequest();
    $request->setUserResolver(fn() => $user); // 👈 attach the user manually

    $rules = $request->rules();

    expect($rules)->toHaveKeys(['name', 'email', 'password']);
});
