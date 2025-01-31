<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Http\Resources\Usuario\UsuarioCollection;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Models\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios->loadMissing(["tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    public function store(StoreUsuarioRequest $request) {
        $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

        if (!$tipoUsuario) {
            return response("El tipo de usuario introducido n es válido", 404);
        }

        $nuevoUsuario = new Usuario($request->all());
        $nuevoUsuario->save();

        return new UsuarioResource($nuevoUsuario->loadMissing(["tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    public function update(UpdateUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($request->id_tipo_usuario) {
            $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

            if (!$tipoUsuario) {
                return response("El tipo de usuario introducido n es válido", 404);
            }
        }

        if ($usuario) {
            $usuario->update($request->all());

            return new UsuarioResource($usuario->loadMissing(["tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 404);
        }
    }

    public function show($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            return new UsuarioResource($usuario->loadMissing(["tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 404);
        }
    }

    public function destroy($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return response(true);

        } else {
            return response("No existe el usuario indicado", 404);
        }
    }


}
