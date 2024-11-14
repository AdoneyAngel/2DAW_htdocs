<?php

namespace App\Http\Controllers;

use App\Models\Xml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class peliculas extends Controller
{
    public function index() {
        if (!$this->isLogged()) {
            return redirect()->route("login");
        }

        $user = Session::get("user");

        return view("main", ["user" => $user]);
    }

    private function isLogged() {
        return Session::has("user");
    }

    public function getPeliculas() {
        $peliculas = Xml::getPeliculas();

        return response(json_encode($peliculas));
    }

    public function getPeliculasPagina($pagina) {
        $peliculas = Xml::getPeliculas();

        return response(json_encode($peliculas[$pagina]));
    }

    public function getNumeroPeliculas() {
        $peliculas = Xml::getPeliculas();

        return response(json_encode(count($peliculas)));
    }
}
