<?php

use App\Models\User;
use Spatie\Permission\Models\Role;




test('the application returns a successful response', function () {
    Role::firstOrCreate(['name' => 'developer']);

    $user = User::factory()->create();
    $user->assignRole('developer');

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
});
