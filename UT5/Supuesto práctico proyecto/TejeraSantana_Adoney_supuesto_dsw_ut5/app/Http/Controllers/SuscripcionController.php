<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuscripcionRequest;
use App\Http\Requests\UpdateSuscripcionRequest;
use App\Http\Resources\SuscripcionCollection;
use App\Http\Resources\SuscripcionResource;
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
            return response("No existe la suscripción indicada", 500);
        }
    }

    public function show($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 500);
        }
    }

    public function destroy($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->delete();

            return response(true);

        } else {
            return response("No existe la suscripción indicada", 500);
        }
    }
}
