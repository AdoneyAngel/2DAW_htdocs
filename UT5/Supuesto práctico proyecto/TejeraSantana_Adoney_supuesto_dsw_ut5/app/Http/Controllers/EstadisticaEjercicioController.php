<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaEjercicio\DeleteEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\StoreEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\UpdateEstadisticaEjercicioRequest;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioCollection;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioResource;
use App\Models\Ejercicio;
use App\Models\EstadisticaEjercicio;

class EstadisticaEjercicioController extends Controller
{
    public function index() {
        $estadisticas = EstadisticaEjercicio::all();

        return new EstadisticaEjercicioCollection($estadisticas->loadMissing(["ejercicio"]));
    }

    public function store(StoreEstadisticaEjercicioRequest $request) {
        $ejercicio = Ejercicio::find($request->id_ejercicio);

        if (!$ejercicio) {
            return response("No se ha podido encontrar el ejercicio indicado", 404);
        }

        $estadistica = new EstadisticaEjercicio($request->all());
        $estadistica->save();

        return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));
    }

    public function update(UpdateEstadisticaEjercicioRequest $request, $estadisticaId) {
        if ($request->id_ejercicio) {
            $ejercicio = Ejercicio::find($request->id_ejercicio);

            if (!$ejercicio) {
                return response("No se ha podido encontrar el ejercicio indicado", 404);
            }

        }

        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 404);
        }
    }

    public function show($estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 404);
        }
    }

    public function destroy(DeleteEstadisticaEjercicioRequest $request, $estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadistica indicada", 404);
        }
    }
}
