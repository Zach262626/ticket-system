<?php

namespace App\Models\Ticket;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tickets';
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
    protected $fillable   = [
        'description',
        'status_id',
        'level_id',
        'type_id',
        'created_by',
        'accepted_by',
    ];

    /**
     * A ticket belongs to one status.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * A ticket belongs to one level.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(TicketLevel::class, 'level_id');
    }

    /**
     * A ticket belongs to one type.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TicketType::class, 'type_id');
    }

    /**
     * A ticket attachments.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    /**
     * The user who created the ticket.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user who accepted the ticket.
     */
    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
    /**
     * A ticket messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'ticket_id');
    }
}
