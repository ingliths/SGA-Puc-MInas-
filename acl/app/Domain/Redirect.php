<?php

namespace App\Domain;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class Redirect
{
    function redirect($url, Request $request)
    {
        if ($request->getMethod() == "GET") {
           return  Http::get($url.$request->path());
        }
        if ($request->getMethod() == "POST") {

        }
        if ($request->getMethod() == "PATCH") {

        }

        if ($request->getMethod() == "DELETE") {

        }


    }
}
