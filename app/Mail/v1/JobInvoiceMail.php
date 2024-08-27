<?php

namespace App\Mail\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $payment;
    protected $job;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $payment, $job)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->job = $job;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.v1.job-invoice-mail',
            with: [
                'user' => $this->user,
                'payment' => $this->payment,
                'job' => $this->job
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
