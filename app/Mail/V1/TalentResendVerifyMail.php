<?php

namespace App\Mail\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TalentResendVerifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $talent;

    /**
     * Create a new message instance.
     */
    public function __construct($talent)
    {
        $this->talent = $talent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Talent Resend Verify Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'v1/mail.talentresend',
            with: [
                'message' => $this->talent,
                'otp' => $this->verificationLink($this->talent)
            ],
        );
    }

    protected function verificationLink($talent)
    {
        return route('verification.verify', ['token' => $talent->otp]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
