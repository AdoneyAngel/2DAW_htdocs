<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function loginView() {
        return view("login");
    }

    public function login(Request $request) {
        $request->validate([
            "usuario" => "required",
            "clave" => "required"
        ]);

        $usuarioEncontrado = Usuario::where(["usuario" => $request->usuario, "clave" => $request->clave])->first();

        if ($usuarioEncontrado) {
            return redirect("/");

        } else {
            return view("login", ["error" => "El usuario o contraseña no son correctos"]);
        }
    }
}
