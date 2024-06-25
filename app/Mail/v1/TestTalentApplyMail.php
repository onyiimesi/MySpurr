<?php

namespace App\Mail\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestTalentApplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobapply;
    public $talent;
    public $business;
    public $job;
    public $jobs;

    /**
     * Create a new message instance.
     */
    public function __construct($jobapply, $talent, $business, $job, $jobs)
    {
        $this->jobapply = $jobapply;
        $this->talent = $talent;
        $this->business = $business;
        $this->job = $job;
        $this->jobs = $jobs;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Sent',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'v1.mail.talentapply',
            with: [
                'jobapply' => $this->jobapply,
                'talent' => $this->talent,
                'business' => $this->business,
                'job' => $this->job,
                'jobs' => $this->jobs
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
