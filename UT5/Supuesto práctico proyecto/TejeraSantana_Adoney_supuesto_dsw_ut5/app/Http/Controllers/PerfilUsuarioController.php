<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilUsuario\DeletePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\StorePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    public function index() {
        $perfilesUsuarios = PerfilUsuario::all();

        return new PerfilUsuarioCollection($perfilesUsuarios->loadMissing(["usuario"]));
    }

    public function store(StorePerfilUsuarioRequest $request) {
        $cliente = Usuario::find($request->id_usuario);

        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 404);
        }

        $perfilUsuario = new PerfilUsuario($request->all());
        $perfilUsuario->save();

        return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));
    }

    public function update(UpdatePerfilUsuarioRequest $request, $perfilUsuarioId) {
        if ($request->id_usuario) {
            $cliente = Usuario::find($request->id_usuario);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 404);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 406);
            }
        }

        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->update($request->all());

            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 404);
        }
    }

    public function show($perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 404);
        }
    }

    public function destroy(DeletePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 404);
        }
    }
}
