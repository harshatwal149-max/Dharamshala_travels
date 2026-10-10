<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Booking $booking)
    {
        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        $type = ucfirst($this->booking->booking_type ?: 'cab');

        return new Envelope(
            subject: "New {$type} booking {$this->booking->booking_code} — {$this->booking->customer_name}",
            replyTo: array_filter([$this->booking->customer_email]),
        );
    }

    public function content(): Content
    {
        $this->booking->loadMissing('vehicle', 'package');

        return new Content(view: 'emails.new-booking');
    }
}
