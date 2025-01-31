<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilUsuario\DeletePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\StorePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    public function index() {
        $perfilesUsuarios = PerfilUsuario::all();

        return new PerfilUsuarioCollection($perfilesUsuarios->loadMissing(["usuario"]));
    }

    public function store(StorePerfilUsuarioRequest $request) {
        $perfilUsuario = new PerfilUsuario($request->all());
        $perfilUsuario->save();

        return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));
    }

    public function update(UpdatePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->update($request->all());

            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function show($perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function destroy(DeletePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }
}
