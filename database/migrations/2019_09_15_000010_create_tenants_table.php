<?php

declare (strict_types = 1);

use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id')->primary();

            // your custom columns may go here
            $table->string('name');
            $table->string('tenancy_db_username', 512)->nullable();
            $table->string('tenancy_db_password', 512)->nullable();

            $table->timestamps();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Tenant::forAll()->each(function ($tenant) {
            Schema::dropIfExists(config('tenancy.database.tenant_database_prefix')
                . $tenant->id
                . config('tenancy.database.tenant_database_suffix'));
        });
        Schema::dropIfExists('tenants');
    }
}
