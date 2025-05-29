<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);
        $user = User::create([
            'name'     => 'Zachary Gallant',
            'email'    => 'zachgallant26@gmail.com',
            'password' => 'Contendo2025!',
        ]);
        $user->syncRoles(Role::where('name', 'developer')->get());
    }
}
