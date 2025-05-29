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

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [];
        $role1 = Role::create(['name' => 'developer']);
        $role2 = Role::create(['name' => 'member']);
        $role3 = Role::create(['name' => 'admin']);
        $role4 = Role::create(['name' => 'support']);
        $permissions[0] = Permission::create(['name' => 'edit tickets']);
        $permissions[1] = Permission::create(['name' => 'comment tickets']);
        $permissions[2] = Permission::create(['name' => 'status tickets']);
        $permissions[3] = Permission::create(['name' => 'create tickets']);
        $permissions[4] = Permission::create(['name' => 'view all tickets']);
        $permissions[5] = Permission::create(['name' => 'delete tickets']);
        $permissions[6] = Permission::create(['name' => 're-assign tickets']);
        // Developer has all permissions
        $role1->givePermissionTo($permissions);
        $role2->givePermissionTo([$permissions[3], $permissions[1]]); // Only create/comment tickets
        $role3->givePermissionTo(array_slice($permissions, 0, 5)); // All except delete and re-assign
        // Admin has all permissions
        $role4->givePermissionTo($permissions);

        $permissions = [];
        $permissions[] = Permission::create(['name' => 'view roles']);
        $permissions[] = Permission::create(['name' => 'edit roles']);
        $permissions[] = Permission::create(['name' => 'delete roles']);
        $permissions[] = Permission::create(['name' => 'create roles']);
        $permissions[] = Permission::create(['name' => 'assign roles']);
        $role1->givePermissionTo($permissions); // Developer can view/edit/create users
        $role3->givePermissionTo([$permissions[0], $permissions[4]]); // Admin can view/ass
    }
}
