<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoSerie\DeleteTipoSerieRequest;
use App\Http\Requests\TipoSerie\StoreTipoSerieRequest;
use App\Http\Requests\TipoSerie\UpdateTipoSerieRequest;
use App\Http\Resources\TipoSerie\TipoSerieCollection;
use App\Http\Resources\TipoSerie\TipoSerieResource;
use App\Models\TipoSerie;
use Illuminate\Http\Request;

class TipoSerieController extends Controller
{
    public function index() {
        $tiposSerie = TipoSerie::all();

        return new TipoSerieCollection($tiposSerie->loadMissing(["series"]));
    }

    public function store(StoreTipoSerieRequest $request) {
        $tipoSerie = new TipoSerie($request->all());
        $tipoSerie->save();

        return new TipoSerieResource($tipoSerie->loadMissing(["series"]));
    }

    public function update(UpdateTipoSerieRequest $request, $tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            $tipoSerie->update($request->all());

            return new TipoSerieResource($tipoSerie->loadMissing(["series"]));

        } else {
            return response("No existe el tipo de serie indicado", 404);
        }
    }

    public function show($tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            return new TipoSerieResource($tipoSerie->loadMissing(["series"]));

        } else {
            return response("No existe el tipo de serie indicado", 404);
        }
    }

    public function destroy(DeleteTipoSerieRequest $request, $tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            $tipoSerie->delete();

            return response(true);

        } else {
            return response("No existe el tipo de serie indicado", 404);
        }
    }
}
