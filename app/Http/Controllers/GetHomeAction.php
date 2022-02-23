<?php

namespace App\Http\Controllers;

use App\Services\Ford\Vehicle;
use Illuminate\Support\Facades\Cache;

class GetHomeAction extends Controller
{
    public function __invoke(Vehicle $service)
    {
        return view('home', Cache::remember('homepage', 1000000, fn () => [
            'status' => $service->status()['vehiclestatus'] ?? [],
            'capabilities' => $service->capabilities()['result'] ?? [],
            'details' => $service->details()['vehicle'] ?? [],
        ]));
    }
}
