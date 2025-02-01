<?php

namespace App\Http\Controllers;

use App\Http\Requests\Serie\DeleteSerieRequest;
use App\Http\Requests\Serie\StoreSerieRequest;
use App\Http\Requests\Serie\UpdateSerieRequest;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Ejercicio;
use App\Models\Serie;
use App\Models\TablaEntrenamiento;
use App\Models\TipoSerie;

class SerieController extends Controller
{
    public function index() {
        $series = Serie::all();

        return new SerieCollection($series->loadMissing(["tipoSerie", "ejercicio", "tablaEntrenamiento"]));
    }

    public function store(StoreSerieRequest $request) {
        $tipoSerie = TipoSerie::find($request->id_tipo_serie);
        $tabla = TablaEntrenamiento::find($request->id_tabla);
        $ejercicio = Ejercicio::find($request->id_ejercicio);

        //Comprobaciones
        if (!$tipoSerie) {
            return response("No existe el tipo de serie",205);
        }
        if (!$tabla) {
            return response("La tabla de entrenamiento no existe",205);
        }
        if (!$ejercicio) {
            return response("El ejercicio indicado no existe",205);
        }
        if ($request->repeticiones_min <= 0) {
            return response("El número de repeticiones mínimas no es válido", 205);
        }
        if ($request->repeticiones_max <= 0) {
            return response("El número de repeticiones máximas no es válido", 205);
        }
        if ($request->repeticiones_max < $request->repeticiones_min) {
            return response("El número de repeticiones máximas no puede ser menor que el número de repeticiones mínimo", 205);
        }
        if ($request->peso <= 0) {
            return response("El peso no es válido", 205);
        }
        if ($request->duracion <= 0) {
            return response("La duración no es válida", 205);
        }
        if ($request->descanso <= 0) {
            return response("El descanso no es válido", 205);
        }

        $serie = new Serie($request->all());
        $serie->save();

        return new SerieResource($serie->loadMissing(["tipoSerie", "ejercicio", "tablaEntrenamiento"]));
    }

    public function update(UpdateSerieRequest $request, $serieId) {
        $serie = Serie::find($serieId);

        //Comprobaciones
        $repeticionesMinimas = $request->repeticiones_min ?? $serie->repeticiones_min;
        $repeticionesMaximas = $request->repeticiones_max ?? $serie->repeticiones_max;

        if ($request->id_tipo_serie) {
            $tipoSerie = TipoSerie::find($request->id_tipo_serie);

            if (!$tipoSerie) {
                return response("No existe el tipo de serie",205);
            }
        }
        if ($request->id_tabla) {
            $tabla = TablaEntrenamiento::find($request->id_tabla);

            if (!$tabla) {
                return response("La tabla de entrenamiento no existe",205);
            }
        }
        if ($request->id_ejercicio) {
            $ejercicio = Ejercicio::find($request->id_ejercicio);

            if (!$ejercicio) {
                return response("El ejercicio indicado no existe",205);
            }
        }
        if (is_numeric($request->repeticiones_min) && $request->repeticiones_min <= 0) {
            return response("El número de repeticiones mínimas no es válido", 205);
        }
        if (is_numeric($request->repeticiones_max) && $request->repeticiones_max <= 0) {
            return response("El número de repeticiones máximas no es válido", 205);
        }
        if ((is_numeric($request->repeticiones_max) || is_numeric($request->repeticiones_min))) {
            if ($repeticionesMinimas > $repeticionesMaximas) {
                return response("El número de repeticiones máximas no puede ser menor que el número de repeticiones mínimo", 205);
            }
        }
        if (is_numeric($request->peso) && $request->peso <= 0) {
            return response("El peso no es válido", 205);
        }
        if (is_numeric($request->duracio) && $request->duracion <= 0) {
            return response("La duración no es válida", 205);
        }
        if (is_numeric($request->descanso) && $request->descanso <= 0) {
            return response("El descanso no es válido", 205);
        }

        if ($serie) {
            $serie->update($request->all());

            return new SerieResource($serie->loadMissing(["tipoSerie", "ejercicio", "tablaEntrenamiento"]));

        } else {
            return response("No se ha encontrado al serie indicado", 205);
        }
    }

    public function show($serieId) {
        $serie = Serie::find($serieId);

        if ($serie) {
            return new SerieResource($serie->loadMissing(["tipoSerie", "ejercicio", "tablaEntrenamiento"]));

        } else {
            return response("No se ha encontrado al serie indicado", 205);
        }
    }

    public function destroy(DeleteSerieRequest $request, $serieId) {
        $serie = Serie::find($serieId);

        if ($serie) {
            $serie->delete();

            return response(true);

        } else {
            return response("No se ha encontrado al serie indicado", 205);
        }
    }
}
