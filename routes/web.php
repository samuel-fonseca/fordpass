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

$router->group([
    'prefix' => 'ui',
], function () use ($router) {
    $router->get('/info', 'GetInfoAction');
});

$router->group([
    'prefix' => 'api',
    'namespace' => 'Vehicle',
], function () use ($router) {
    $router->get('/vehicle/{vin}/position', 'GetVehiclePosition');
    $router->get('/vehicle/{vin}/{command}', 'SendVehicleCommandAction');
});
