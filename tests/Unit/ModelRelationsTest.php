<?php

use App\Models\User;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAttachment;
use App\Models\Ticket\TicketMessage;
use App\Models\Ticket\TicketLevel;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/** @var \Tests\TestCase $this */

