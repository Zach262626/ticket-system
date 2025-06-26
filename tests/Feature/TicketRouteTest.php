<?php

use Stancl\Tenancy\Facades\Tenancy;
use App\Models\Tenant;
use App\Models\User;
use Spatie\Permission\Models\Role;


beforeEach(function () {
    $this->tenant    = Tenant::create(
        [
            'id' => fake()->unique()->randomNumber(),
            'name'                => 'Test Company',
            'tenancy_db_username' => 'testDomain',
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
test('the tenant application returns a successful response', function () {
    Role::firstOrCreate(['name' => 'developer']);

    $user = User::factory()->create();
    $user->assignRole('developer');

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
});
