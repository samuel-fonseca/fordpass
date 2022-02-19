<?php

namespace App\Console\Commands;

use App\Services\Ford\Vehicle;
use Illuminate\Console\Command;

class VehicleControl extends Command
{
    protected $signature = 'vehicle:control {action}';

    protected $description = 'Control your Ford vehicle from the console';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Vehicle $service)
    {
        $command = $this->argument('action');
        if (method_exists($service, $command)) {
            $response = $service->{$command}();

            foreach ($response as $k => $v) {
                $this->info($k . ': ' . $v);
            }
        } else {
            $this->error(sprintf('The command "%s" is invalid.', $command));
        }
    }
}
