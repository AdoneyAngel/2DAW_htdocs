<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        return response(view("producto.productos", compact("productos")));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();

        return response(view("producto.añadir", compact("categorias")));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "nombre" => "required|min:1",
                "descripcion" => "required|min:1",
                "stock" => "required|min:0",
                "categoria" => "required|min:1"
            ]);

            //Validar que la categoria existe
            if (!Categoria::exist($request->categoria)) {
                throw new \Exception("La categoría no existe");
            }

            //Validar que no haya un producto con el mismo nombre y de la misma categoria
            $productoRepetido = Producto::where(["nombre" => $request->nombre, "categoria" => $request->categoria])->exists();

            if ($productoRepetido) {
                throw new \Exception("El producto ya está repetido en la misma categoría");
            }

            $nuevoProducto = new Producto();
            $nuevoProducto->nombre = $request->nombre;
            $nuevoProducto->descripcion = $request->descripcion;
            $nuevoProducto->stock = $request->stock;
            $nuevoProducto->categoria = $request->categoria;
            $nuevoProducto->save();

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));

        } catch(\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $producto = Producto::find($id);
            $producto->delete();

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));

        } catch(\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }
}
