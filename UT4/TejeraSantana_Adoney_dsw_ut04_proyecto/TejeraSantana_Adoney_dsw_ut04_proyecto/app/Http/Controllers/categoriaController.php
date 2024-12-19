<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return response(view("categoria.categorias", compact("categorias")));
    }

    public function listaProductos($id) {
        try {
            $categoria = Categoria::find($id);

            if ($categoria) {
                $productos = $categoria->productos;
                $error = false;

                if (!count($productos)) {
                    $error = "Categoria sin productos";
                }

                return response(view("producto.productos", compact("productos", "error")));

            } else {
                return response(json_encode([
                    "respuesta" => false,
                    "error" => "La categoria no existe"
                ]));
            }

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response(view("categoria.añadir"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "nombre" => "required|min:1",
                "descripcion" => "required|min:1"
            ]);

            //Validar que la categoría no existe
            $categoriaEncontrada = Categoria::where("nombre", $request->nombre)->exists();

            if ($categoriaEncontrada) {
                throw new \Exception("La categoría ya está creada");
            }

            $nuevaCategoria = new Categoria();
            $nuevaCategoria->nombre = $request->nombre;
            $nuevaCategoria->descripcion = $request->descripcion;
            $nuevaCategoria->save();

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
        try {
            $categoria = Categoria::find($id);

            return response(view("categoria.editar", compact("categoria")));

        } catch (\Exception $err) {
            return response()->json(["error" => $err->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                "nombre" => "required|min:1",
                "descripcion" => "required|min:1"
            ]);

            $categoria = Categoria::find($id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));


        } catch(\Exception $err) {
            return response(json_encode([
                "respuestsa" => false,
                "error" => $err->getMessage()
            ]));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $categoria = Categoria::find($id);
            $categoria->delete();

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));

        } catch(\Exception $err) {
            return response(json_encode([
                "respuestsa" => false,
                "error" => $err->getMessage()
            ]));
        }
    }
}
