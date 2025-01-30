<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuscripcionRequest;
use App\Http\Resources\SuscripcionCollection;
use App\Http\Resources\SuscripcionResource;
use App\Models\Suscripcion;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{
    public function index() {
        $suscripciones = Suscripcion::all();

        return new SuscripcionCollection($suscripciones->loadMissing("cliente"));
    }

    public function store(StoreSuscripcionRequest $request) {
        $nuevaSuscripcion = new Suscripcion($request->all());
        $nuevaSuscripcion->save();

        return new SuscripcionResource($nuevaSuscripcion->loadMissing("cliente"));
    }

    public function update(UpdateTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->update($request->all());

            return new TipoUsuarioResource($tipoUsuario->loadMissing("cliente"));

        } else {
            return response("No existe el tipo de usuario indicado", 500);
        }
    }

    public function show($tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            return new TipoUsuarioResource($tipoUsuario->loadMissing("cliente"));

        } else {
            return response("No existe el tipo de usuario indicado", 500);
        }
    }

    public function destroy($tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->delete();

            return response(true);

        } else {
            return response("No existe el tipo de usuario indicado", 500);
        }
    }
}
