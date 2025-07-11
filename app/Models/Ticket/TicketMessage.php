<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TicketMessage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'ticket_id',
        'sender_id',
    ];
    /**
     * A message belongs to one ticket.
     */
    public function ticket(): BelongsTo
    {
        return $this->BelongsTo(Ticket::class, 'ticket_id');
    }
    /**
     * A message has one sender.
     */
    public function sender(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'sender_id', 'id');
    }
}
