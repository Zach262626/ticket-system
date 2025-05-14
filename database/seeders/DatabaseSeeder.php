<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::create(
            [
                'id' => 'foo',
            ]
        );

        $tenant->domains()->create([
            'domain'=> 'foo.localhost',
        ]);
    }
}
