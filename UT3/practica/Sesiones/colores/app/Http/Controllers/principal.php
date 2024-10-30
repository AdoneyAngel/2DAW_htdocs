<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class principal extends Controller
{
    public function index() {

        if (Session::has("color")) {
            return view("principal", ["color" => Session::get("color")]);

        } else {
            return redirect("/seleccionar");
        }

    }

    public function subir(Request $request) {
        if ($request->has("color")) {
            $color = $request->get("color");

            Session::put("color", $color);

            return $this->index();

        } else {
            return redirect("/seleccionar");
        }
    }

    public function logout() {
        Session::flush();

        return $this->index();
    }
}
