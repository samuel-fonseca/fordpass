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

$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->get('login', 'LoginController@show');
    $router->post('login', 'LoginController@store');
});

$router->group([
    'prefix' => '/',
    'middleware' => 'auth',
], function () use ($router) {
    $router->get('/', 'GetHomeAction');
});

$router->group([
    'prefix' => 'api',
    'namespace' => 'Vehicle',
    'middleware' => 'throttle:2,1',
], function () use ($router) {
    $router->get('/vehicle/{vin}/position', 'GetVehiclePosition');
    $router->get('/vehicle/{vin}/{command}', 'SendVehicleCommandAction');
});
