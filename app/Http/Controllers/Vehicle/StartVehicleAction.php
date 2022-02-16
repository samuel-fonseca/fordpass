<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Services\Ford\Vehicle;

class StartVehicleAction extends Controller
{
    public function __invoke(Vehicle $service)
    {
        return response()->json($service->start());
    }
}
