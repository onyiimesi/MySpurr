<?php

namespace App\Providers;

use App\Events\v1\BusinessWelcomeEvent;
use App\Events\V1\MessagingEvent;
use App\Events\v1\TalentWelcomeEvent;
use App\Listeners\v1\BusinessWelcome;
use App\Listeners\v1\TalentWelcome;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TalentWelcomeEvent::class => [
            TalentWelcome::class
        ],
        BusinessWelcomeEvent::class => [
            BusinessWelcome::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
