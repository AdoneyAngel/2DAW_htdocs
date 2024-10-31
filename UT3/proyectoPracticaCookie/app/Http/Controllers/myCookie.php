<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class myCookie extends Controller
{
    public function make($value) {

        $myCookie = Cookie::make("myCookie", $value);

        return response(view("cookie", ["myCookie" => $value]))->cookie($myCookie);
    }

    public function cambiarFuente(Request $request) {
        if (!empty($request->input("fuente"))) {
            $fuenteCookie = Cookie::make("fuente", $request->input("fuente"));

            return response(view("formulario", ["fuente" => $request->input("fuente")]))->withCookie($fuenteCookie);

        } else {
            return $this->index();
        }
    }

    public function index() {
        $fuente = 15;

        if (Cookie::has("fuente")) {
            $fuente = Cookie::get("fuente");
        }

        return view("formulario", ["fuente" => $fuente]);
    }
}
