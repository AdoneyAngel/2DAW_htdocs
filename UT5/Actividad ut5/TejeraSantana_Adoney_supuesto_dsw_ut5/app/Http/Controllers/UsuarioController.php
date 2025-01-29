<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStore;
use App\Http\Resources\UsuarioCollection;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function registrar() {
        //crear los usuarios por defecto administrador, actualizador y visor

        $tokenAdmin = "";
        $tokenActu = "";
        $tokenVisor = "";

        //comprobar si ya están creados
        if (!User::where("name", "Administrador")->first()) {
            $administrador = new User([
                "name" => "Administrador",
                "email" => "administrador@gmail.com",
                "password" => "1234"
            ]);

            $administrador->save();

            $tokenAdmin = $administrador->createToken("admin-token", ["create", "update", "delete"])->plainTextToken;
        }

        if (!User::where("name", "Actualizador")->first()) {
            $actualizador = new User([
                "name" => "Actualizador",
                "email" => "actualizador@gmail.com",
                "password" => "1234"
            ]);

            $actualizador->save();

            $tokenActu = $actualizador->createToken("actu-token", ["update"])->plainTextToken;
        }

        if (!User::where("name", "Visor")->first()) {
            $visor = new User([
                "name" => "Visor",
                "email" => "visor@gmail.com",
                "password" => "1234"
            ]);

            $visor->save();

            $tokenVisor = $visor->createToken("visor-token", [])->plainTextToken;
        }

        return response(json_encode([
            "administrador-token" => $tokenAdmin,
            "actualizador-token" => $tokenActu,
            "visor-token" => $tokenVisor
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
            "email" => $request->email,
        ]);

        $nuevoUsuario->save();
    }
}
