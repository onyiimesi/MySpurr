<?php

namespace App\Mail\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobPaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $payment;
    protected $job;
    protected $link;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $payment, $job, $link = null)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->job = $job;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Job Payment Invoice Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.v1.job-payment-invoice-mail',
            with: [
                'user' => $this->user,
                'payment' => $this->payment,
                'job' => $this->job,
                'link' => $this->link,
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
