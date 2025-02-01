<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaEjercicio\DeleteEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\StoreEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\UpdateEstadisticaEjercicioRequest;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioCollection;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioResource;
use App\Models\Ejercicio;
use App\Models\EstadisticaEjercicio;
use DateTime;

class EstadisticaEjercicioController extends Controller
{
    public function index() {
        $estadisticas = EstadisticaEjercicio::all();

        return new EstadisticaEjercicioCollection($estadisticas->loadMissing(["ejercicio"]));
    }

    public function store(StoreEstadisticaEjercicioRequest $request) {
        $ejercicio = Ejercicio::find($request->id_ejercicio);

        //Comprobaciones
        if (!$ejercicio) {
            return response("No se ha podido encontrar el ejercicio indicado", 205);
        }
        if ($request->num_sesiones <= 0) {
            return response("El número de sesiones no es válido", 205);
        }
        if ($request->tiempo_total <= 0) {
            return response("El tiempo total no es válido", 205);
        }
        if ($request->duracion_media <= 0) {
            return response("La duración media no es válida", 205);
        }
        if ($request->sets_completados < 0) {
            return response("Los sets_completados no son válidos", 205);
        }
        if ($request->volumen_total < 0) {
            return response("El volumen total no es válido", 205);
        }
        if ($request->repeticiones_totales < 0) {
            return response("Las repeticiones totales no son válidos", 205);
        }
        if (new DateTime($request->fecha_entrenamiento) > new DateTime("now")) {
            return response("La fecha de entrenamiento no es válido", 205);
        }

        $estadistica = new EstadisticaEjercicio($request->all());
        $estadistica->save();

        return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));
    }

    public function update(UpdateEstadisticaEjercicioRequest $request, $estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        //Comprobaciones
        if ($request->id_ejercicio) {
            $ejercicio = Ejercicio::find($request->id_ejercicio);

            if (!$ejercicio) {
                return response("No se ha podido encontrar el ejercicio indicado", 205);
            }

        }
        if (!$ejercicio) {
            return response("No se ha podido encontrar el ejercicio indicado", 205);
        }
        if ($request->num_sesiones != null && $request->num_sesiones <= 0) {
            return response("El número de sesiones no es válido", 205);
        }
        if ($request->num_sesiones != null && $request->tiempo_total <= 0) {
            return response("El tiempo total no es válido", 205);
        }
        if ($request->num_sesiones != null && $request->duracion_media <= 0) {
            return response("La duración media no es válida", 205);
        }
        if ($request->num_sesiones != null && $request->sets_completados < 0) {
            return response("Los sets_completados no son válidos", 205);
        }
        if ($request->num_sesiones != null && $request->volumen_total < 0) {
            return response("El volumen total no es válido", 205);
        }
        if ($request->num_sesiones != null && $request->repeticiones_totales < 0) {
            return response("Las repeticiones totales no son válidos", 205);
        }
        if ($request->fecha_entrenamiento != null && (new DateTime($request->fecha_entrenamiento) > new DateTime("now"))) {
            return response("La fecha de entrenamiento no es válido", 205);
        }

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }

    public function show($estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }

    public function destroy(DeleteEstadisticaEjercicioRequest $request, $estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }
}
