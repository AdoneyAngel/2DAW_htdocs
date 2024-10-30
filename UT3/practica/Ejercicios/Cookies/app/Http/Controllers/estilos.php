<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class estilos extends Controller
{
    public function index() {
        //Cargar cookie
        $color = null;

        if (Cookie::has("color")) {
            $color = Cookie::get("color");
        }

        return view("estilos", ["color" => $color]);
    }
}
