<?php

namespace App\Http\Controllers;

use App\Http\Requests\TablaEntrenamiento\StoreTablaEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\UpdateTablaEntrenamientoRequest;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoCollection;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoResource;
use App\Models\TablaEntrenamiento;

class TablaEntrenamientoController extends Controller
{
    public function index() {
        $tablas = TablaEntrenamiento::all();

        return new TablaEntrenamientoCollection($tablas->loadMissing("planesEntrenamiento"));
    }

    public function store(StoreTablaEntrenamientoRequest $request) {
        $tabla = new TablaEntrenamiento($request->all());
        $tabla->save();

        return new TablaEntrenamientoResource($tabla->loadMissing("planesEntrenamiento"));
    }

    public function update(UpdateTablaEntrenamientoRequest $request, $tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->update($request->all());

            return new TablaEntrenamientoResource($tabla->loadMissing("planesEntrenamiento"));

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }

    public function show($tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            return new TablaEntrenamientoResource($tabla->loadMissing("planesEntrenamiento"));

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }

    public function destroy($tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->delete();

            return response(true);

        } else {
            return response("No existe la tabla indicada", 500);
        }
    }
}
