<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ejercicio\DeleteEjercicioRequest;
use App\Http\Requests\Ejercicio\StoreEjercicioRequest;
use App\Http\Requests\Ejercicio\UpdateEjercicioRequest;
use App\Http\Resources\Ejercicio\EjercicioCollection;
use App\Http\Resources\Ejercicio\EjercicioResource;
use App\Models\Ejercicio;
use App\Models\TipoMusculo;

class EjercicioController extends Controller
{
    public function index() {
        $ejercicios = Ejercicio::all();

        return new EjercicioCollection($ejercicios->loadMissing(["tipoMusculo", "series", "estadisticas"]));
    }

    public function store(StoreEjercicioRequest $request) {
        $tipoMusculo = TipoMusculo::find($request->id_tipo_musculo);

        if (!$tipoMusculo) {
            return response("El tipo de músuculo indicado no existe", 205);
        }

        $ejercicio = new Ejercicio($request->all());
        $ejercicio->save();

        return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));
    }

    public function update(UpdateEjercicioRequest $request, $ejercicioId) {
        if ($request->id_tipo_musculo) {
            $tipoMusculo = TipoMusculo::find($request->id_tipo_musculo);

            if (!$tipoMusculo) {
                return response("El tipo de músuculo indicado no existe", 205);
            }
        }

        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->update($request->all());

            return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }

    public function show($ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }

    public function destroy(DeleteEjercicioRequest $request, $ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->delete();

            return response(true);

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }
}
