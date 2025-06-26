<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenants';
    /**
     * The database connection that should be used by the model.
     * @var string
     */
    protected $connection = 'mysql';
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'tenancy_db_username',
            'tenancy_db_password',
        ];
    }
    protected $casts = [
        'tenancy_db_password' => 'encrypted',
    ];
    /**
     * Get the tags that should be assigned to the job.
     *
     * @return  array
     */
    public function tags()
    {
        return [
            'tenant:' . tenant('id'),
        ];
    }
}
