<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'namespace' => 'Vehicle'], function () use ($router) {
    $router->get('/vehicle/status', 'GetVehicleStatusAction');
    $router->get('/vehicle/start', 'StartVehicleAction');
    $router->get('/vehicle/stop', 'StopVehicleAction');
    $router->get('/vehicle/lock', 'LockDoorAction');
    $router->get('/vehicle/unlock', 'UnlockDoorAction');
});
