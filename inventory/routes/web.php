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

    $api->group(["prefix" => "products"], function ($module) {
        $module->get('/', 'ProductController@index');
        $module->post('/', 'ProductController@store');
        $module->patch('/{id}', 'ProductController@update');
        $module->get('/{id}', 'ProductController@show');
        $module->delete('/{id}', 'ProductController@delete');
    });

    $api->group(["prefix" => "categories"], function ($module) {
        $module->get('/', 'CategoryController@index');
        $module->post('/', 'CategoryController@store');
        $module->patch('/{id}', 'CategoryController@update');
        $module->get('/{id}', 'CategoryController@show');
        $module->delete('/{id}', 'CategoryController@delete');
    });

    $api->group(["prefix" => "vendors"], function ($module) {
        $module->get('/', 'VendorController@index');
        $module->post('/', 'VendorController@store');
        $module->patch('/{id}', 'VendorController@update');
        $module->get('/{id}', 'VendorController@show');
        $module->delete('/{id}', 'VendorController@delete');
    });
});

