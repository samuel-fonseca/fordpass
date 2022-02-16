<?php

namespace App\Http\Controllers;

use App\Services\Ford\Ford;

class GetFordTokenAction extends Controller
{
    public function __invoke(Ford $service)
    {
        return response()->json($service->getToken());
    }
}
