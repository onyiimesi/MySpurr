<?php

namespace App\Console\Commands;

use App\Models\V1\Business;
use Illuminate\Console\Command;

class BusinessAccountSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business-account:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Onboarding email for businesses on how to setup their account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Business::chunk(30, function ($businesses) {
            foreach ($businesses as $business) {
                $business->sendAccountSetupEmail();
            }
        });
    }
}
