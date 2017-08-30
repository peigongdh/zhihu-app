<?php

namespace App\Console;

use App\Console\Commands\CreateElasticsearchIndex;
use App\Console\Commands\TestElaticsearchQuery;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateElasticsearchIndex::class,
        TestElaticsearchQuery::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('inspire')
//            ->hourly();
//        $schedule->command('es:create')
//            ->daily()
//            ->appendOutputTo(config('schedule.es_create'));
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
