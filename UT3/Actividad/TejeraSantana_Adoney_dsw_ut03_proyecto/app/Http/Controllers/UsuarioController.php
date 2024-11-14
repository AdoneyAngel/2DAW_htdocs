<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function isLogged() {
        $response = null;

        if (Session::has("Usuario") && Session::has("Carrito")) {
            $response = [
                "respuesta" => true,
                "error" => ""
            ];

        } else {
            $response = [
                "respuesta" => false,
                "error" => ""
            ];
        }

        return response(json_encode($response));
    }

    public function login(Request $request) {
        $validacionRequest = $request->validate([
            "usuario" => "required",
            "clave" => "required"
        ]);

        $usuarios = $this->usuarioModel->getUsuarios();
        $response = [
            "respuesta" => false,
            "error" => ""
        ];

        if (!$validacionRequest) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Faltan parámetros"
            ]));
        }

        foreach ($usuarios as $usuario) {
            if ($usuario["usuario"] == $request->usuario && $usuario["clave"] == $request->clave) {//Usuarios correctos
                $response["respuesta"] = true;

                Session::put("Usuario", $request->usuario);
                Session::put("Carrito", []);

            } else {
                $response["respuesta"] = false;
            }
        }

        return response(json_encode($response));
    }

    public function logout() {
        Session::flush();

        return response(json_encode([
            "respuesta" => true,
            "error" => ""
        ]));
    }
}
