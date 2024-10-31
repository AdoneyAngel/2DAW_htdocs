<?php

namespace App\Http\Controllers;

use App\Models\Idiomas;
use App\Models\ZonasHorarias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Sesion extends Controller
{
    public function guardar(Request $request) {
        if ($request->has("idioma") && $request->has("publico") && $request->has("zonaHoraria")) {
            //Guardar los datos a la sesion
            Session::put("idioma", $request->get("idioma"));
            Session::put("publico", $request->get("publico"));
            Session::put("zonaHoraria", $request->get("zonaHoraria"));

            return $this->index();

        } else {
            return redirect("/");
        }


    }

    public function index() {
        if (Session::has("idioma") && Session::has("publico") && Session::has("zonaHoraria")) {
            $viewData = [
                "idioma" => Idiomas::getFromName(Session::get("idioma")),
                "publico" => Session::get("publico") == 1 ? "Si" : "No",
                "zonaHoraria" => ZonasHorarias::getFromName(Session::get("zonaHoraria")),
            ];

            return view("sesion", $viewData);

        } else {
            return redirect("/");
        }
    }

    public function borrar() {
        Session::flush();

        return redirect("/");
    }
}
