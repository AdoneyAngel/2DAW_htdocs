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

        $usuario = Session::get("Usuario");

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
        $usuarios = $this->usuarioModel->getUsuarios();

        $response = [
            "respuesta" => false,
            "error" => ""
        ];

        $validacionRequest = $request->validate([
            "usuario" => "required",
            "clave" => "required"
        ]);

        if (!$validacionRequest) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Faltan parámetros"
            ]));
        }

        foreach ($usuarios as $usuario) {
            if ($usuario["usuario"] == $request->usuario && $usuario["clave"] == $request->clave) {//Usuarios correctos

                Session::put("Usuario", $request->usuario);
                Session::put("Carrito", []);

                try {//Se guarda al sesion al fichero
                    Usuario::guardarInicioSesion();

                    $response["respuesta"] = true;
                    $response["error"] = "";

                } catch (\Exception $err) {
                    $response["respuesta"] = false;
                    $response["error"] = $err->getMessage();
                }


            } else {
                $response["respuesta"] = false;
            }
        }

        return response(json_encode($response));
    }

    public function logout() {

        try {//Se guarda el cierre de sesion
            Usuario::guardarCierreSesion();

            Session::flush();
            Session::regenerate();
            Session::start();//Se crea una nueva sesion, ya que la pagina no se va a recargar

            return response(json_encode([
                "respuesta" => true,
                "error" => "",
                "token" => csrf_token()//Se pasa el token regenerado
            ]));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }

    public function cargarUsuario() {
        $usuario = Usuario::getUsuario();

        return json_encode($usuario);
    }

    public function obtenerAccesos() {
        try {
            $accesos = Usuario::getAccesos();

            return response(json_encode($accesos));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }
}
