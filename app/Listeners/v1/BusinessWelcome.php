<?php

namespace App\Listeners\v1;

use App\Events\v1\BusinessWelcomeEvent;
use App\Mail\v1\BusinessWelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BusinessWelcome
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
    public function handle(BusinessWelcomeEvent $event): void
    {
        Mail::to($event->user->email)->send(new BusinessWelcomeMail($event->user));
    }
}
