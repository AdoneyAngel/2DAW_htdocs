<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsuariosController extends Controller
{
    public function login(Request $request) {
        try {
            $request->validate([
                "usuario" => "required|min:1",
                "clave" => "required|min:1"
            ]);

            $usuarioBuscado = Usuario::where([
                "usuario" => $request->usuario,
                "clave" => $request->clave
            ])->first();

            if ($usuarioBuscado) {
                //Se guarda en la sesion
                Session::put("nombre_usuario", $request->usuario);
                Session::put("usuario", $usuarioBuscado->id);

                return response(json_encode([
                    "respuesta" => true,
                    "usuario" => $request->usuario,
                    "error"=>""
                ]));

            } else {
                return response(json_encode([
                    "respuesta" => false,
                    "error"=>""
                ]));
            }

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }

    }

    public function logout() {
        try {
            Session::flush();
            Session::regenerate();
            Session::start();

            return response(json_encode([
                "respuesta" => true,
                "token" => csrf_token(),
                "error" => ""
            ]));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }

    public function loginView() {
        return response(view("login"));
    }

    public static function isLogged() {
        try {
            $logueadoUsuario = Session::has("usuario");
            $logueadoNombreUsuario = Session::has("nombre_usuario");

            return response(json_encode([
                "respuesta" => $logueadoUsuario&&$logueadoNombreUsuario ? true : false,
                "usuario" => Session::get("nombre_usuario"),
                "error" => ""
            ]));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }

    }
}
