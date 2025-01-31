<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suscripcion\StoreSuscripcionRequest;
use App\Http\Requests\Suscripcion\UpdateSuscripcionRequest;
use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\Suscripcion\SuscripcionResource;
use App\Models\Suscripcion;

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

    public function update(UpdateSuscripcionRequest $request, $suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->update($request->all());

            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 404);
        }
    }

    public function show($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 404);
        }
    }

    public function destroy($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->delete();

            return response(true);

        } else {
            return response("No existe la suscripción indicada", 404);
        }
    }
}
