<?php

namespace App\Mail\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventPostponedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $event;
    protected $user;
    protected $setting;

    /**
     * Create a new message instance.
     */
    public function __construct($event, $user, $setting)
    {
        $this->event = $event;
        $this->user = $user;
        $this->setting = $setting;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MySpurr Event Postponed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.v1.event-postponed-mail',
            with: [
                'event' => $this->event,
                'user' => $this->user,
                'setting' => $this->setting
            ]
        );
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
