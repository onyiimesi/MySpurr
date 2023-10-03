<?php

namespace App\Listeners\v1;

use App\Events\v1\TalentWelcomeEvent;
use App\Mail\v1\TalentWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class TalentWelcome
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TalentWelcomeEvent $event): void
    {
        Mail::to($event->email)->send(new TalentWelcomeMail());
    }
}
