<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Services\Ford\Vehicle;

class SendVehicleCommandAction extends Controller
{
    private $safeCommands = [
        'lock',
        'unlock',
        'start',
        'stop',

        'status',
    ];

    public function __invoke(string $vin, string $command, Vehicle $service)
    {
        if (in_array($command, $this->safeCommands)) {
            return response()->json(
                $service
                    ->vin($vin)
                    ->{$command}()
            );
        }

        abort(404);
    }
}
