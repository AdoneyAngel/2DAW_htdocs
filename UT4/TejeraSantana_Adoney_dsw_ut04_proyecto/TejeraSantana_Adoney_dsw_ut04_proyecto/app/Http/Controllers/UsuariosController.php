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
            ])->get();

            if (count($usuarioBuscado)) {
                //Se guarda en la sesion
                Session::put("usuario", $request->usuario);

                return response(json_encode([
                    "respuesta" => true,
                    "error"=>""
                ]));

            } else {
                return response(json_encode([
                    "respuesta" => false,
                    "error"=>"Usuario no encontrado"
                ]));
            }

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }

    }
}
