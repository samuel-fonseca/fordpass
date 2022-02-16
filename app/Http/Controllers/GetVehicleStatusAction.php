<?php

namespace App\Http\Controllers;

use App\Services\Ford\Vehicle;

class GetVehicleStatusAction extends Controller
{
    public function __invoke(Vehicle $service)
    {
        return response()->json($service->status());
    }
}
