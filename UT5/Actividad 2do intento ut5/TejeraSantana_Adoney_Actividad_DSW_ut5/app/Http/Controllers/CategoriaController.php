<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCategoriaRequest;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index() {
        $categorias = Categoria::all();

        return new CategoriaCollection($categorias->loadMissing("posts"));
    }

    public function store(StoreCategoriaRequest $request) {
        $categoria = new Categoria($request->all());
        $categoria->save();

        return new CategoriaResource($categoria->loadMissing("posts"));
    }

    public function update(UpdateCategoriaRequest $request, $categoriaId) {
        $categoria = Categoria::find($categoriaId);

        if ($categoria) {
            $categoria->update($request->all());

            return new CategoriaResource($categoria->loadMissing("posts"));

        } else {
            return response(false, 500);
        }
    }

    public function destroy(DeleteCategoriaRequest $request, $categoriaId) {
        $categoria = Categoria::find($categoriaId);

        if ($categoria) {
            $categoria->delete();

            return response(true, 200);

        } else {
            return response(false, 500);
        }
    }

    public function show ($categoriaId) {
        $categoria = Categoria::find($categoriaId);

        if ($categoria) {

            return new CategoriaResource($categoria->loadMissing("posts"));

        } else {
            return response(false, 500);
        }
    }

}
