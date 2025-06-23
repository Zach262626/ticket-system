<?php

namespace App\Mail;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class TicketDeletedMail extends Mailable
{
    use Queueable, SerializesModels;
    public string $tenantDomainPath;
    public function __construct(
        public array $ticket,
        public string $tenantDomain
    ) {
        $scheme = app()->environment('local') ? 'http' : 'https';
        $port   = app()->environment('local') && str_ends_with($tenantDomain, '.localhost')
            ? ':' . env('APP_PORT', 8000)
            : '';

        $this->tenantDomainPath = "{$scheme}://{$tenantDomain}{$port}";
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Ticket #{$this->ticket['id']} Deleted",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.tickets.deleted',
            with: [
                'ticket' => $this->ticket,
                'tenantDomainPath' => $this->tenantDomainPath
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            messageId: "ticket-{$this->ticket['id']}-" . uniqid() . "@{$this->tenantDomain}",
            references: ["ticket-{$this->ticket['id']}@{$this->tenantDomain}"],
            text: [
                'X-Custom-Header' => 'Custom Value',
            ],
        );
    }
}
