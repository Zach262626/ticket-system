<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketLevel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket_levels';
    /**
     * The database connection that should be used by the model.
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    /**
     * Get the tickets associated with this level.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'level_id');
    }
}
