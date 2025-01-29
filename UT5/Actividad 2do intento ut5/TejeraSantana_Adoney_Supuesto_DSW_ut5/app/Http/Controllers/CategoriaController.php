<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index() {
        $categorias = Categoria::all();

        return new CategoriaCollection($categorias);
    }

    public function store(StoreCategoriaRequest $request) {
        $categoria = new Categoria($request->all());
        $categoria->save();

        return new CategoriaResource($categoria);
    }

    public function update(UpdateCategoriaRequest $request, $categoriaId) {
        $categoria = Categoria::find($request->all());

        if ($categoria) {
            $categoria->update($request->all());

            return new CategoriaResource($categoria);

        } else {
            return response(false, 500);
        }
    }

}
