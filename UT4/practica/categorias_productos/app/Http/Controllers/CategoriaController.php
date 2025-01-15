<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index() {
        $categorias = Categoria::all();
        return view("categorias.categorias", compact("categorias"));
    }

    public function create() {
        return view("categorias.create");
    }

    public function store(Request $request) {
        $request->validate([
            "nombre" => "required",
            "descripcion" => "required"
        ]);

        try {
            $nuevaCategoria = new Categoria();
            $nuevaCategoria->nombre = $request->nombre;
            $nuevaCategoria->descripcion = $request->descripcion;
            $nuevaCategoria->save();

            return redirect()->route("categorias.index");

        } catch (\Exception $err) {
            return view("categorias.create", ["error" => $err]);
        }
    }

    public function edit(Categoria $categoria) {
        return view("categorias.edit", compact("categoria"));
    }

    public function update(Request $request, $id) {
        $validacion = $request->validate([
            "nombre" => "required",
            "descripcion" => "required"
        ]);

        try {
            $Categoria = Categoria::find($id);

            $Categoria->update($validacion);

            return redirect()->route("categorias.index");

        } catch (\Exception $err) {
            return view("categorias.edit", ["error" => $err, "categoria" => Categoria::find($id)]);
        }
    }

    public function destroy($id) {
        $categoria = Categoria::find($id);

        $categoria->delete();

        return redirect()->route("categorias.index");
    }

    public function productos($id) {
        $categoria = Categoria::find($id);

        $productos = $categoria->productos;

        return view("categorias.productos", compact("productos"));
    }
}
