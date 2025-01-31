<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
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

        //Borrar el usuario si ya existe, para poder regenerar el token

        //comprobar si ya están creados
        if (User::where("name", "Administrador")->first()) {
            $admin = User::where("name", "Administrador")->first();
            $admin->delete();

        }

        if (User::where("name", "Actualizador")->first()) {
            $actu = User::where("name", "Actualizador")->first();
            $actu->delete();
        }

        if (User::where("name", "Visor")->first()) {
            $visor = User::where("name", "Visor")->first();
            $visor->delete();
        }

        //Administrador
        $administrador = new User([
            "name" => "Administrador",
            "email" => "administrador@gmail.com",
            "password" => "1234"
        ]);
        $actualizador = new User([
            "name" => "Actualizador",
            "email" => "actualizador@gmail.com",
            "password" => "1234"
        ]);
        $visor = new User([
            "name" => "Visor",
            "email" => "visor@gmail.com",
            "password" => "1234"
        ]);

        $administrador->save();
        $actualizador->save();
        $visor->save();

        $tokenAdmin = $administrador->createToken("admin-token", ["create", "update", "delete"])->plainTextToken;
        $tokenActu = $actualizador->createToken("actu-token", ["update"])->plainTextToken;
        $tokenVisor = $visor->createToken("visor-token", [])->plainTextToken;

        return response(json_encode([
            "administrador-token" => $tokenAdmin,
            "actualizador-token" => $tokenActu,
            "visor-token" => $tokenVisor
        ]));
    }

    public function index() {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios->loadMissing("posts"));
    }

    public function create() {}

    public function store(StoreUsuarioRequest $request) {
        $nuevoUsuario = new Usuario([
            "nombre" => $request->nombre,
            "email" => $request->email,
            "apellidos" => $request->apellidos,
        ]);

        $nuevoUsuario->save();

        return new UsuarioResource($nuevoUsuario->loadMissing("posts"));
    }

    public function update(UpdateUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->update($request->all());

            return new UsuarioResource($usuario->loadMissing("posts"));
        } else {
            response(false, 500);
        }
    }

    public function destroy(DeleteUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return response(true);

        } else {
            return response(false, 5000);
        }
    }

    public function show($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {

            return new UsuarioResource($usuario);

        } else {
            return response(false, 5000);
        }
    }
}
