<?php

namespace App\Http\Controllers\ejercicio3;

use App\Http\Controllers\Controller;
use App\Models\ejercicio3\ProductoEj3;
use Illuminate\Http\Request;

class productoControllerEj3 extends Controller
{
    public function index() {
        try {
            $productos = ProductoEj3::getProductos();

            if (count($productos) > 0) {
                return response(view("ejercicio3.productosEj3", ["productos" => $productos]));

            } else {
                return response(view("ejercicio3.productosEj3", ["productos"=>[], "error"=>"No existen detalles para este producto"]));
            }

        } catch (\Exception $err) {
            return response(view("ejercicio3.productosEj3", ["productos"=>[], "error"=>"Se ha producido un error inesperado en la aplicación"]));
        }

    }

    public function detalles($id) {
        if (isset($id) && !empty($id)) {
            try {
                $productoBuscado = ProductoEj3::getDetalles($id);

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
