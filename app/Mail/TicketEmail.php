<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

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
     * Subject email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket: ' . $this->transaction->event->name,
        );
    }

    /**
     * View email
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
     * Attach QR Code
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->transaction->tickets as $ticket) {
            if ($ticket->qr_code_path && Storage::disk('public')->exists($ticket->qr_code_path)) {
                $attachments[] = Attachment::fromPath(
                    Storage::disk('public')->path($ticket->qr_code_path)
                )
                ->as($ticket->ticket_code . '.png')
                ->withMime('image/png');
            }
        }

        return $attachments;
    }
}