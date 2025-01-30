<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios->loadMissing("tipoUsuario"));
    }

    public function store(StoreUsuarioRequest $request) {
        $nuevoUsuario = new Usuario($request->all());
        $nuevoUsuario->save();

        return new UsuarioResource($nuevoUsuario->loadMissing("tipoUsuario"));
    }

    public function update(UpdateUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->update($request->all());

            return new UsuarioResource($usuario->loadMissing("tipoUsuario"));

        } else {
            return response("No existe el usuario indicado", 500);
        }
    }

    public function show($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            return new UsuarioResource($usuario->loadMissing("tipoUsuario"));

        } else {
            return response("No existe el usuario indicado", 500);
        }
    }

    public function destroy($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return response(true);

        } else {
            return response("No existe el usuario indicado", 500);
        }
    }


}
