<?php

namespace App\Mail;

use App\Models\Ticket\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public string $tenantDomain
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ticket #{$this->ticket->id} Created",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tickets.created',
            with: [
                'ticket' => $this->ticket,
                'tenantDomain' => $this->tenantDomain
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
    
}
