<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoMusculoRequest;
use App\Http\Requests\UpdateTipoMusculoRequest;
use App\Http\Resources\TipoMusculoCollection;
use App\Http\Resources\TipoMusculoResource;
use App\Models\TipoMusculo;
use Illuminate\Http\Request;

class TipoMusculoController extends Controller
{

    public function index() {
        $tiposMusculo = TipoMusculo::all();

        return new TipoMusculoCollection($tiposMusculo);
    }

    public function store(StoreTipoMusculoRequest $request) {
        $tipoMusculo = new TipoMusculo($request->all());
        $tipoMusculo->save();

        return new TipoMusculoResource($tipoMusculo);
    }

    public function update(UpdateTipoMusculoRequest $request, $tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            $tipoMusculo->update($request->all());

            return new TipoMusculoResource($tipoMusculo);

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function show($tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            return new TipoMusculoResource($tipoMusculo);

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }

    public function destroy($tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            $tipoMusculo->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 500);
        }
    }
}
