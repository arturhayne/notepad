<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PushNotificationsCommand;

class Kernel extends ConsoleKernel
{

    //Cron command
    //
    // * * * * * cd /Users/arturhayne/Projects/notepad/notepad/ && php artisan schedule:run >> /dev/null 2>&1
    ///
    
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\PushNotificationsCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command(PushNotificationsCommand::class, ['notepad'])->everyMinute();
        $schedule->command('domain:events:spread notepad')
            ->everyMinute()
            ->appendOutputTo(base_path('.eventsOutput'));
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
