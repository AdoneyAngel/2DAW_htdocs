<?php

namespace App\Http\Controllers\ejercicio2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ejercicio2\Tarea;
use Illuminate\Support\Facades\Session;

class tareaController extends Controller
{
    public function index() {
        $tareas = Tarea::getTareas();

        return view("ejercicio2.tareas", ["tareas" => $tareas]);
    }

    public function agregar(Request $request) {
        try {
            $request->validate([
                "nombre"=>"required|min:1",
                "descripcion"=>"required|min:1"
            ]);

            Tarea::agregar($request->nombre, $request->descripcion);

            return response(json_encode(["respuesta"=>true]));

        } catch(\Exception $err) {
            return response(json_encode(["respuesta"=>false, "error" => "Datos incompletos de la tarea, rellene todos los datos"]));
        }
    }
}
