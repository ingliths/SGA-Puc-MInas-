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

$router->group(["middleware" => 'auth'], function ($api) {
    $api->group(["prefix" => "deliveries"], function ($module) {
        $module->get('/', 'DeliveryController@index');
        $module->post('/', 'DeliveryController@store');
        $module->patch('/{id}', 'DeliveryController@update');
        $module->get('/{id}', 'DeliveryController@show');
        $module->delete('/{id}', 'DeliveryController@delete');
    });
});


