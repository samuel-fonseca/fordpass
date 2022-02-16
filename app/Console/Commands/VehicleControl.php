<?php

namespace App\Console\Commands;

use App\Services\Ford\Vehicle;
use Illuminate\Console\Command;

class VehicleControl extends Command
{
    protected $signature = 'vehicle:control {--command=}';

    protected $description = 'Control your Ford vehicle from the console';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Vehicle $service)
    {
        //{"$id":"1","commandId":"3c83ef5b-de02-4986-b528-d7799d0c7b46","status":200,"version":"1.0.0"}
        $response = match ($this->option('command')) {
            'start' => $service->start(),
            'stop' => $service->stop(),
            'lock' => $service->lock(),
            'unlock' => $service->unlock(),
            default => [],
        };

        foreach ($response as $k => $v) {
            $this->info($k . ': ' . $v);
        }
    }
}
