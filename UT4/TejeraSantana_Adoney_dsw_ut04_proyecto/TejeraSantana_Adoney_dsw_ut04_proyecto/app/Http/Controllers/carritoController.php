<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class carritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!UsuariosController::isLogged()) {
            throw new \Exception("Debe iniciar sesion para acceder a su carrrito");
        }

        $usuario = Usuario::find(Session::get("usuario"));

        $carrito = $usuario->productosCarrito;

        return response(view("carrito.carrito", ["carrito" => $carrito]));
    }

    public function guardarProducto(Request $request) {
        try {
            $request->validate([
                "producto" => "required|min:1",
                "unidades" => "required|min:1"
            ]);

            //Validar si el roducto no existe
            if (!Producto::exist($request->producto)) {
                throw new \Exception("El producto no existe");
            }

            //Validar que tiene la sesion iniciad
            if (!UsuariosController::isLogged()) {
                throw new \Exception("Debe iniciar sesion para realizar esta accion");
            }

            $usuario = Usuario::find(Session::get("usuario"));

            if ($usuario->productosCarrito()->where("producto", $request->producto)->first()) {
                $productoCarrito = $usuario->productosCarrito()->where("producto", $request->producto)->first();
                $productoCarrito->unidades += $request->unidades;
                $productoCarrito->save();

            } else {
                $usuario->productosCarrito()->create([
                    "unidades" => $request->unidades,
                    "producto" => $request->producto
                    ]);
            }

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }

    }

    public function eliminarProducto(Request $request) {
        try {
            $request->validate([
                "producto" => "required|min:1",
                "unidades" => "required|min:1"
            ]);

            if (!UsuariosController::isLogged()) {
                throw new \Exception("Debe iniciar sesion para realizar la peticion");
            }

            $usuario = Usuario::find(Session::get("usuario"));

            if ($usuario->productosCarrito()->where("producto", $request->producto)) {
                $productoCarrito = $usuario->productosCarrito()->where("producto", $request->producto)->first();

                if ($productoCarrito->unidades - $request->unidades <= 0) {
                    $productoCarrito->delete();

                } else {
                    $productoCarrito->unidades -= $request->unidades;
                    $productoCarrito->save();
                }
            }

            return response(json_encode([
                "respuesta" => true,
                "error" => ""
            ]));

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    private function buscar($id) {
        $carrito = Carrito::find($id);

        return $carrito;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
