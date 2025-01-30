<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadisticaClienteRequest;
use App\Http\Requests\UpdateEstadisticaClienteRequest;
use App\Http\Resources\EstadisticaClienteCollection;
use App\Http\Resources\EstadisticaClienteResource;
use App\Models\EstadisticaCliente;
use Illuminate\Http\Request;

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

    public function destroy($estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadísticas indicadas", 500);
        }
    }
}
