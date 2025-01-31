<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suscripcion\StoreSuscripcionRequest;
use App\Http\Requests\Suscripcion\UpdateSuscripcionRequest;
use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\Suscripcion\SuscripcionResource;
use App\Models\Suscripcion;
use App\Models\Usuario;

class SuscripcionController extends Controller
{
    public function index() {
        $suscripciones = Suscripcion::all();

        return new SuscripcionCollection($suscripciones->loadMissing("cliente"));
    }

    public function store(StoreSuscripcionRequest $request) {
        $cliente = Usuario::find($request->id_cliente);

        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }

        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 401);
        }

        $nuevaSuscripcion = new Suscripcion($request->all());
        $nuevaSuscripcion->save();

        return new SuscripcionResource($nuevaSuscripcion->loadMissing("cliente"));
    }

    public function update(UpdateSuscripcionRequest $request, $suscripcionId) {
        if ($request->id_cliente) {
            $cliente = Usuario::find($request->id_cliente);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 401);
            }
        }

        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->update($request->all());

            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }

    public function show($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }

    public function destroy($suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->delete();

            return response(true);

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }
}
