<?php

namespace App\Http\Controllers;

use App\Services\Ford\Vehicle;

class GetInfoAction extends Controller
{
    public function __invoke(Vehicle $service)
    {
        return view('info', [
            'status' => $service->status()['vehiclestatus'] ?? [],
            'capabilities' => $service->capabilities()['result'] ?? [],
            'details' => $service->details()['vehicle'] ?? [],
        ]);
    }
}
