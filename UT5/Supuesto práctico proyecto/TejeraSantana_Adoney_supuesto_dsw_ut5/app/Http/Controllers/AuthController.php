<?php

namespace App\Http\Controllers;

use App\Models\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registrar() {
        $tipoUsuarioAdmin = TipoUsuario::where("tipo_usuario", "administrador")->first();
        $tipoUsuarioGestor = TipoUsuario::where("tipo_usuario", "gestor")->first();
        $tipoUsuarioEntrena = TipoUsuario::where("tipo_usuario", "entrenador")->first();
        $tipoUsuarioNutricion = TipoUsuario::where("tipo_usuario", "nutricionista")->first();
        $tipoUsuarioCliente = TipoUsuario::where("tipo_usuario", "cliente")->first();

        $administrador = Usuario::where("email", "administrador@gmail.com")->first();
        $gestor = Usuario::where("email", "gestor@gmail.com")->first();
        $entrenador = Usuario::where("email", "entrenador@gmail.com")->first();
        $nutricionista = Usuario::where("email", "nutricionista@gmail.com")->first();
        $cliente = Usuario::where("email", "cliente@gmail.com")->first();

        $tokenAdmin = "";
        $tokenGestor = "";
        $tokenEntrena = "";
        $tokenNutricion = "";

        $permisosAdmin = ["admin"];
        $permisosGestor = ["usuarios", "perfil-clientes", "ejercicios", "estadisticas-clientes", "suscripciones"];
        $permisosEntrenador = ["planes-entrenamientos", "tablas-entrenamientos", "series", "estadisticas-ejercicios"];
        $permisosNutricionista = ["planes-nutricionales"];

        //Administrador
        if (!$administrador) {//Si ya existe vuelve a generar un token para al menos poder utilizar el token válido
            $administrador = new Usuario([
                "email" => "administrador@gmail.com",
                "clave" => Hash::make("1234"),
                "id_tipo_usuario" => $tipoUsuarioAdmin->id_tipo_usuario
            ]);

            $administrador->save();
        }
        $tokenAdmin = $administrador->createToken("admin-token", $permisosAdmin)->plainTextToken;
        $administrador->token = $tokenAdmin;
        $administrador->save();

        //Gestor
        if (!$gestor) {
            $gestor = new Usuario([
                "email" => "gestor@gmail.com",
                "clave" => Hash::make("1234"),
                "id_tipo_usuario" => $tipoUsuarioGestor->id_tipo_usuario
            ]);

            $gestor->save();
        }
        $tokenGestor = $gestor->createToken("gestor-token", $permisosGestor)->plainTextToken;
        $gestor->token = $tokenGestor;
        $gestor->save();

        //Entrenador
        if (!$entrenador) {
            $entrenador = new Usuario([
                "email" => "entrenador@gmail.com",
                "clave" => Hash::make("1234"),
                "token" => "12345Token",
                "id_tipo_usuario" => $tipoUsuarioEntrena->id_tipo_usuario
            ]);

            $entrenador->save();
        }
        $tokenEntrena = $entrenador->createToken("entrenador-token", $permisosEntrenador)->plainTextToken;
        $entrenador->token = $tokenEntrena;
        $entrenador->save();

        //Nutricionista
        if (!$nutricionista) {
            $nutricionista = new Usuario([
                "email" => "nutricionista@gmail.com",
                "clave" => Hash::make("1234"),
                "token" => "12345Token",
                "id_tipo_usuario" => $tipoUsuarioNutricion->id_tipo_usuario
            ]);

            $nutricionista->save();
        }
        $tokenNutricion = $nutricionista->createToken("entrenador-token", $permisosNutricionista)->plainTextToken;
        $nutricionista->token = $tokenNutricion;
        $nutricionista->save();

        //Cliente
        if (!$cliente) {
            $cliente = new Usuario([
                "email" => "cliente@gmail.com",
                "clave" => Hash::make("1234"),
                "token" => "12345Token",
                "id_tipo_usuario" => $tipoUsuarioCliente->id_tipo_usuario
            ]);

            $cliente->save();
        }
        $tokenCliente = $cliente->createToken("entrenador-token", [])->plainTextToken;
        $cliente->token = $tokenCliente;
        $cliente->save();

        return response([
            "token_admin" => $tokenAdmin,
            "token_gestor" => $tokenGestor,
            "token_entrenador" => $tokenEntrena,
            "token_nutricionista" => $tokenNutricion,
            "token_cliente" => $tokenCliente
        ]);
    }

    public static function authRequest($usuario, $permisos = []) {
        if (!$usuario || $usuario == null) {
            return false;
        }

        if ($usuario->tokenCan("admin")) {
            return true;
        }

        foreach ($permisos as $permisoActual) {
            if ($usuario->tokenCan($permisoActual)) {
                return true;
            }
        }

        return false;
    }

    public static function UnauthorizedError($message = "No tienes autorización para realizar esta operación" ) {
        return response($message, 401);
    }
}
