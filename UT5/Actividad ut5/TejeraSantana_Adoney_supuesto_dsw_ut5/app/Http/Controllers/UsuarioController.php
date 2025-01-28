<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStore;
use App\Http\Resources\UsuarioCollection;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function registrar() {
        //crear los usuarios por defecto administrador, actualizador y visor

        $tokenAdmin = "";
        $tokenActu = "";

        //comprobar si ya están creados
        if (!Usuario::where("nombre", "Administrador")->first()) {
            $administrador = new Usuario([
                "nombre" => "Administrador",
                "apellidos" => "El admin de la actividad",
                "email" => "administrador@gmail.com"
            ]);

            $administrador->save();

            $tokenAdmin = $administrador->createToken("admin-token", ["create", "update", "delete"]);
        }

        if (!Usuario::where("nombre", "Actualizador")->first()) {
            $actualizador = new Usuario([
                "nombre" => "Actualizador",
                "apellidos" => "Parcheador",
                "email" => "actualizador@gmail.com"
            ]);

            $actualizador->save();

            $tokenActu = $actualizador->createToken("actu-token", ["create", "update"]);
        }

        if (!Usuario::where("nombre", "Visor")->first()) {
            $visor = new Usuario([
                "nombre" => "Visor",
                "apellidos" => "Espectador",
                "email" => "visor@gmail.com"
            ]);

            $visor->save();
        }

        return response(json_encode([
            "administrador-token" => $tokenAdmin->plainTextToken,
            "actualizador-token" => $tokenActu->plainTextToken
        ]));
    }

    public function index() {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios);
    }

    public function create() {}

    public function store(UsuarioStore $request) {
        $nuevoUsuario = new Usuario([
            "nombre" => $request->nombre,
            "apellidos" => $request->apellidos,
            "email" => $request->email,
        ]);

        $nuevoUsuario->save();
    }
}
