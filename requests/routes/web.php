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
    $api->group(["prefix" => "requests"], function ($module) {
        $module->get('/', 'RequestController@index');
        $module->post('/', 'RequestController@store');
        $module->patch('/{id}', 'RequestController@update');
        $module->get('/{id}', 'RequestController@show');
        $module->delete('/{id}', 'RequestController@delete');
    });

});
