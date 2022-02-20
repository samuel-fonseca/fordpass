<?php

namespace App\Console;

use App\Console\Commands\CreateDatabase;
use App\Console\Commands\Deploy;
use App\Console\Commands\EnvironmentSetCommand;
use App\Console\Commands\VehicleControl;
use App\Console\Commands\VehicleStatus;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        VehicleControl::class,
        VehicleStatus::class,
        Deploy::class,
        CreateDatabase::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
