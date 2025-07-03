<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
it('has tickets relation', function () {
    $user = new User();
    expect($user->tickets())->toBeInstanceOf(HasMany::class);
});

it('has attachments relation', function () {
    $user = new User();
    expect($user->attachments())->toBeInstanceOf(HasMany::class);
});

it('has messages relation', function () {
    $user = new User();
    expect($user->messages())->toBeInstanceOf(HasMany::class);
});
