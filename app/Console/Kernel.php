<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:order')->withoutOverlapping()->runInBackground();
        $schedule->command('send:refill')->withoutOverlapping()->runInBackground();
        $schedule->command('update:balanceProvider')->withoutOverlapping()->runInBackground();
        $schedule->command('update:statusOrder')->withoutOverlapping()->runInBackground();
        $schedule->command('update:statusRefill')->withoutOverlapping()->runInBackground();
        $schedule->command('send:balanceEmail')->withoutOverlapping()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
