<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEjercicioRequest;
use App\Http\Requests\UpdateEjercicioRequest;
use App\Http\Resources\EjercicioCollection;
use App\Http\Resources\EjercicioResource;
use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function index() {
        $ejercicios = Ejercicio::all();

        return new EjercicioCollection($ejercicios->loadMissing("tipoMusculo"));
    }

    public function store(StoreEjercicioRequest $request) {
        $ejercicio = new Ejercicio($request->all());
        $ejercicio->save();

        return new EjercicioResource($ejercicio->loadMissing("tipoMusculo"));
    }

    public function update(UpdateEjercicioRequest $request, $ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->update($request->all());

            return new EjercicioResource($ejercicio->loadMissing("tipoMusculo"));

        } else {
            return response("No existe el ejercicio indicado", 500);
        }
    }

    public function show($ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            return new EjercicioResource($ejercicio->loadMissing("tipoMusculo"));

        } else {
            return response("No existe el ejercicio indicado", 500);
        }
    }

    public function destroy($ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->delete();

            return response(true);

        } else {
            return response("No existe el ejercicio indicado", 500);
        }
    }
}
