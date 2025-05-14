<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement("DROP DATABASE IF EXISTS ticket_system_tenant_foo");
        DB::statement("DROP DATABASE IF EXISTS ticket_system_tenant_bar");
        $tenant = Tenant::query()->create([
            'id' => 'foo',
        ]);
        $tenant2 = Tenant::query()->create([
            'id' => 'bar',
        ]);

        $tenant->domains()->create([
            'domain' => 'foo.localhost',
        ]);
        $tenant2->domains()->create([
            'domain' => 'bar.localhost',
        ]);
    }
}
