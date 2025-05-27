<?php

namespace Database\Seeders;

use App\Models\Tenant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TenantTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ticket_status')->insert([
            ['name' => 'open'],
            ['name' => 'in_progress'],
            ['name' => 'closed'],
        ]);
        DB::table('ticket_type')->insert([
            ['name' => 'general'],
            ['name' => 'bug'],
            ['name' => 'feature_request'],
        ]);
        DB::table('ticket_level')->insert([
            ['name' => 'low'],
            ['name' => 'medium'],
            ['name' => 'high'],
            ['name' => 'critical'],
        ]);
    }
}
