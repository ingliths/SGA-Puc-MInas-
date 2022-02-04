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
    $api->group(["prefix" => "clients"], function ($module) {
        $module->get('/tickets', 'ClientController@tickets');
        $module->group(["prefix" => "ticket"], function ($ticket) {
            $ticket->post('/', 'ClientController@ticketStore');
            $ticket->post('/{id}/entry', 'ClientController@ticketEntryStore');
            $ticket->get('/{id}', 'ClientController@ticketShow');
        });
    });
});


