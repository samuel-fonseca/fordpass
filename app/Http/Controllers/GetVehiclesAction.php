<?php

namespace App\Http\Controllers;

use App\Services\Ford\Vehicle;

class GetVehiclesAction extends Controller
{
    public function __invoke(Vehicle $vehicle)
    {
        return response()->json($vehicle->getAll());
    }
}
