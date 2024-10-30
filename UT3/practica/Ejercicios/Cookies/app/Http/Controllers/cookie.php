<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie as FacadesCookie;

class cookie extends Controller
{
    public function guardar(Request $request) {
        if ($request->has("color")) {
            $cookie = FacadesCookie::make("color", $request->get("color"));

            return response(view("guardar_cookie"))->withCookie($cookie);

        } else {
            return redirect("/");
        }
    }
}
