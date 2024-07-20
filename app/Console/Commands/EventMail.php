<?php

namespace App\Console\Commands;

use App\Services\Admin\Event\EventMailService;
use Illuminate\Console\Command;

class EventMail extends Command
{
    protected $eventEmailService;

    public function __construct(EventMailService $eventEmailService)
    {
        parent::__construct();
        $this->eventEmailService = $eventEmailService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:event-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to users registered for active events based on their event type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->eventEmailService->eventEmail();
        $this->info('Emails sent successfully!');
    }
}
