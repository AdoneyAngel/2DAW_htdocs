<?php

namespace App\Http\Controllers;

use App\Http\Requests\TablaEntrenamiento\DeleteTablaEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\DeleteTablaPlanEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\StoreTablaEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\StoreTablaPlanEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\UpdateTablaEntrenamientoRequest;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoCollection;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoResource;
use App\Models\PlanEntrenamiento;
use App\Models\TablaEntrenamiento;

class TablaEntrenamientoController extends Controller
{
    public function index() {
        $tablas = TablaEntrenamiento::all();

        return new TablaEntrenamientoCollection($tablas->loadMissing(["planesEntrenamiento", "series"]));
    }

    public function store(StoreTablaEntrenamientoRequest $request) {
        $tabla = new TablaEntrenamiento($request->all());
        $tabla->save();

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }

    public function update(UpdateTablaEntrenamientoRequest $request, $tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->update($request->all());

            return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }

    public function show($tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }

    public function destroy(DeleteTablaEntrenamientoRequest $request, $tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->delete();

            return response(true);

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }

    public function añadirPlan(StoreTablaPlanEntrenamientoRequest $request, $tabla_id) {
        $plan = PlanEntrenamiento::find($request->id_plan);
        $tabla = TablaEntrenamiento::find($tabla_id);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 500);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 500);
        }

        $tabla->planesEntrenamiento()->attach($plan);

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }

    public function eliminarPlan(DeleteTablaPlanEntrenamientoRequest $request, $tabla_id) {
        $plan = PlanEntrenamiento::find($request->id_plan);
        $tabla = TablaEntrenamiento::find($tabla_id);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 500);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 500);
        }

        $tabla->planesEntrenamiento()->detach($plan);

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }
}
