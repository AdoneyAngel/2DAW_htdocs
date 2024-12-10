<?php

namespace App\Http\Controllers\ejercicio1;

use App\Http\Controllers\Controller;
use App\Models\ejercicio1\Producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    public function index() {
        try {
            $productos = Producto::getProductos();

            if (count($productos) > 0) {
                return response(view("ejercicio1.productos", ["productos" => $productos]));

            } else {
                return response(view("ejercicio1.productos", ["productos"=>[], "error"=>"No existen detalles para este producto"]));
            }

        } catch (\Exception $err) {
            return response(view("ejercicio1.productos", ["productos"=>[], "error"=>"Se ha producido un error inesperado en la aplicación"]));
        }

    }

    public function detalles($id) {
        if (isset($id) && !empty($id)) {
            try {
                $productoBuscado = Producto::getDetalles($id);

                if ($productoBuscado) {
                    return view("ejercicio1.detalles", ["producto" => $productoBuscado]);

                } else {
                    return view("ejercicio1.detalles", ["producto" => [], "error" => "No existen detalles para este producto"]);
                }


            } catch (\Exception $err) {
                return view("ejercicio1.detalles", ["producto" => [], "error" => $err]);
            }


        } else {

        }

    }
}
