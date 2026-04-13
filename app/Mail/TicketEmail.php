<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;

class TicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket: ' . $this->transaction->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
            with: [
                'transaction' => $this->transaction,
                'tickets' => $this->transaction->tickets,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach QR codes untuk setiap ticket
        foreach ($this->transaction->tickets as $ticket) {
            if ($ticket->qr_code_path && \Storage::disk('public')->exists($ticket->qr_code_path)) {
                $attachments[] = Attachment::fromPath(\Storage::disk('public')->path($ticket->qr_code_path))
                    ->as($ticket->ticket_code . '.png')
                    ->withMime('image/png');
            }
        }

        return $attachments;
    }
}
    {
        return [];
    }
}
