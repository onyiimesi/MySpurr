<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
        $schedule->command('queue:prune-batches --hours=48 --unfinished=72')->daily();
        $schedule->command('app:job-suggestion')->weeklyOn(1, '0:00');
        $schedule->command('app:event-mail')->daily();
        $schedule->command('talent-onboarding:email')
            ->withoutOverlapping()
            ->cron('0 0 */3 * *');

        $schedule->command('business-account:setup')
            ->withoutOverlapping()
            ->cron('0 0 */3 * *');

        $schedule->command('business-post:job')
            ->withoutOverlapping()
            ->cron('0 0 */3 * *');

        $schedule->command('business-search:talent')
            ->withoutOverlapping()
            ->cron('0 0 */3 * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
