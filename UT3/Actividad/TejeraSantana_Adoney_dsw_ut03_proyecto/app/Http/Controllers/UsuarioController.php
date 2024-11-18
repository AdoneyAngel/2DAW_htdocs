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

        if (Session::has("Usuario") && Session::has("Carrito") && Session::has("IdSesion")) {
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

        //Se valida los datos
        try {
            $request->validate([
                "usuario" => "required|min:1",
                "clave" => "required|min:1"
            ]);

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Faltan parámetros"
            ]));
        }

        foreach ($usuarios as $usuario) {
            if ($usuario["usuario"] == $request->usuario && $usuario["clave"] == $request->clave) {//Usuarios correctos

                try {//Se guarda al sesion al fichero
                    Session::put("Usuario", $request->usuario);
                    Session::put("Carrito", []);

                    $codigoSesion = Usuario::guardarInicioSesion();

                    Session::put("IdSesion", $codigoSesion);

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
            Usuario::guardarFinSesion();

            Session::flush();
            Session::regenerate();//Si no regenero el token, se mantendrá la sesión activa
            Session::start();//Se crea una nueva sesion, ya que la pagina no se va a recargar

            return response(json_encode([
                "respuesta" => csrf_token(),
                "error" => ""//Se pasa el token regenerado
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
