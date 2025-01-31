<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaCliente\DeleteEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\StoreEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\UpdateEstadisticaClienteRequest;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteCollection;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteResource;
use App\Models\EstadisticaCliente;

class EstadisticaClienteController extends Controller
{
    public function index() {
        $estadisticas = EstadisticaCliente::all();

        return new EstadisticaClienteCollection($estadisticas);
    }

    public function store(StoreEstadisticaClienteRequest $request) {
        $estadistica = new EstadisticaCliente($request->all());
        $estadistica->save();

        return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));
    }

    public function update(UpdateEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 500);
        }
    }

    public function show($estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 500);
        }
    }

    public function destroy(DeleteEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadísticas indicadas", 500);
        }
    }
}
