<?php

namespace App\Http\Controllers;

use App\Domain\Redirect;
use Illuminate\Http\Request;


class GatewayController extends Controller
{

    function redirectStock(Request $request){
        $url =  'http://localhost:8001/';
        return (new Redirect())->redirect($url, $request);
    }




}
