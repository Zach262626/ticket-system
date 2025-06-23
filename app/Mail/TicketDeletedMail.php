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
        public int $ticketId,
        public User $createdBy,
        public ?User $acceptedBy,
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
            subject: "Ticket #{$this->ticketId} Deleted",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.tickets.deleted',
            with: [
                'ticketId' => $this->ticketId,
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
            messageId: "ticket-{$this->ticketId}-" . uniqid() . "@{$this->tenantDomain}",
            references: ["ticket-{$this->ticketId}@{$this->tenantDomain}"],
            text: [
                'X-Custom-Header' => 'Custom Value',
            ],
        );
    }
}
