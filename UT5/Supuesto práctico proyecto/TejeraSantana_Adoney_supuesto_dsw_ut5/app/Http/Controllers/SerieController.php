<?php

namespace App\Http\Controllers;

use App\Http\Requests\Serie\DeleteSerieRequest;
use App\Http\Requests\Serie\StoreSerieRequest;
use App\Http\Requests\Serie\UpdateSerieRequest;
use App\Http\Resources\Serie\SerieCollection;
use App\Http\Resources\Serie\SerieResource;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index() {
        $series = Serie::all();

        return new SerieCollection($series->loadMissing(["tipoSerie", "ejercicio", "tablaEntrenamiento"]));
    }

    public function store(StoreSerieRequest $request) {
        $serie = new Serie($request->all());
        $serie->save();

        return new SerieResource($serie->loadMissing(["tipo_serie", "ejercicio", "tablaEntrenamiento"]));
    }

    public function update(UpdateSerieRequest $request, $serieId) {
        $serie = Serie::find($serieId);

        if ($serie) {
            $serie->update($request->all());

            return new SerieResource($serie->loadMissing(["tipo_serie", "ejercicio", "tablaEntrenamiento"]));

        } else {
            return response("No se ha encontrado al serie indicado", 404);
        }
    }

    public function show($serieId) {
        $serie = Serie::find($serieId);

        if ($serie) {
            return new SerieResource($serie->loadMissing(["tipo_serie", "ejercicio", "tablaEntrenamiento"]));

        } else {
            return response("No se ha encontrado al serie indicado", 404);
        }
    }

    public function destroy(DeleteSerieRequest $request, $serieId) {
        $serie = Serie::find($serieId);

        if ($serie) {
            $serie->delete();

            return response(true);

        } else {
            return response("No se ha encontrado al serie indicado", 404);
        }
    }
}
