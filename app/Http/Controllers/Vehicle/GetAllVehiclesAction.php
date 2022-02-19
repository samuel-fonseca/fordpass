<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Services\Ford\Ford;

class GetAllVehiclesAction extends Controller
{
    public function __invoke(Ford $service)
    {
        return response()->json($service->getVehicles());
    }
}
