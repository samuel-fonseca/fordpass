<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Services\Ford\Vehicle;
use Illuminate\Http\Request;

class GetVehiclePosition extends Controller
{
    public function __invoke(Vehicle $service, Request $request)
    {
        $status = $service->status();

        $position = $status['vehiclestatus']['gps'];

        if ($request->has('for_map')) {
            return response(sprintf('%s,%s', $position['latitude'], $position['longitude']));
        } else {
            return response()->json($position);
        }
    }
}
