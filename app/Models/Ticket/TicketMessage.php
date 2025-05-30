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
    protected $table = 'messages';

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
        'receiver_id',
    ];
    /**
     * A message belongs to one ticket.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    /**
     * A message has one sender.
     */
    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'sender_id');
    }
    /**
     * A message has one receiver.
     */
    public function receiver(): HasOne
    {
        return $this->hasOne(User::class, 'receiver_id');
    }
}
