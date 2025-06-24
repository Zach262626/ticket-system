<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TenantTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ticket_status')->insert([
            ['name' => 'open'],
            ['name' => 'in_progress'],
            ['name' => 'closed'],
        ]);
        DB::table('ticket_types')->insert([
            ['name' => 'general'],
            ['name' => 'bug'],
            ['name' => 'feature_request'],
        ]);
        DB::table('ticket_levels')->insert([
            ['name' => 'low'],
            ['name' => 'medium'],
            ['name' => 'high'],
            ['name' => 'critical'],
        ]);
        $this->call(RoleTableSeeder::class);
        $user = User::create([
            'name'     => 'Zachary Gallant',
            'email'    => 'zachgallant26@gmail.com',
            'password' => 'Contendo2025!',
        ]);
        $user->syncRoles(Role::where('name', 'developer')->get());
    }
}
