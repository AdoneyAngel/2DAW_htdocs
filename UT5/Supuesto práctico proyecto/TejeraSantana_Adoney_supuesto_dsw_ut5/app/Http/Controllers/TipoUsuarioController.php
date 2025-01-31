<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoUsuario\DeleteTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\StoreTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\UpdateTipoUsuarioRequest;
use App\Http\Resources\TipoUsuario\TipoUsuarioCollection;
use App\Http\Resources\TipoUsuario\TipoUsuarioResource;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;

class TipoUsuarioController extends Controller
{
    public function index() {
        $tiposUsuario = TipoUsuario::all();

        return new TipoUsuarioCollection($tiposUsuario->loadMissing("usuarios"));
    }

    public function store(StoreTipoUsuarioRequest $request) {
        $nuevoTipoUsuario = new TipoUsuario($request->all());
        $nuevoTipoUsuario->save();

        return new TipoUsuarioResource($nuevoTipoUsuario->loadMissing("usuarios"));
    }

    public function update(UpdateTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->update($request->all());

            return new TipoUsuarioResource($tipoUsuario->loadMissing("usuarios"));

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }

    public function show($tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            return new TipoUsuarioResource($tipoUsuario->loadMissing("usuarios"));

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }

    public function destroy(DeleteTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->delete();

            return response(true);

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }
}
