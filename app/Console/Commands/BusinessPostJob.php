<?php

namespace App\Console\Commands;

use App\Models\V1\Business;
use Illuminate\Console\Command;

class BusinessPostJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business-post:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Onboarding email for businesses on how to post a job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Business::chunk(30, function ($businesses) {
            foreach ($businesses as $business) {
                $business->sendPostJobEmail();
            }
        });
    }
}
