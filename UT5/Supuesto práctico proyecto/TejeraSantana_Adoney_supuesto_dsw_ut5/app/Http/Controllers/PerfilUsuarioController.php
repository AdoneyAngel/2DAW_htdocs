<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerfilUsuarioRequest;
use App\Http\Requests\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuarioCollection;
use App\Http\Resources\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    public function index() {
        $perfilesUsuarios = PerfilUsuario::all();

        return new PerfilUsuarioCollection($perfilesUsuarios);
    }

    public function store(StorePerfilUsuarioRequest $request) {
        $perfilUsuario = new PerfilUsuario($request->all());
        $perfilUsuario->save();

        return new PerfilUsuarioResource($perfilUsuario->loadMissing("usuario"));
    }

    public function update(UpdatePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->update($request->all());

            return new PerfilUsuarioResource($perfilUsuario->loadMissing("usuario"));

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function show($perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            return new PerfilUsuarioResource($perfilUsuario->loadMissing("usuario"));

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function destroy($perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }
}
