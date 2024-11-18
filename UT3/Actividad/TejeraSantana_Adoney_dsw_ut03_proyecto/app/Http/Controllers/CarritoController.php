<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Libro;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    private $carritoModel;

    public function __construct() {
        $this->carritoModel = new Carrito();
    }

    public function cargarCarrito() {
        $carrito = $this->carritoModel->getCarrito();

        $carritoResponse = [
            [
               "numunidades" => 0,
                "numarticulos" => 0
            ],
        ];

        foreach ($carrito as $item) {
            $carritoResponse[0]["numunidades"] += $item["unidades"];
            $carritoResponse[0]["numarticulos"]++;

            //Cargar datos del item/libro actual (solo se tiene el ISBN)
            $datosLibro = Libro::getLibroDatos($item["isbn"]);

            $libro = $datosLibro;
            $libro["unidades"] = $item["unidades"];

            $carritoResponse[] = $libro;
        }

        return response(json_encode($carritoResponse));
    }

    public function añadirLibros(Request $request) {
        try {
            //Validar que los datos son correctos
            $request->validate([
                "isbn" => "required|min:1",
                "unidades" => "required|min:1"
            ]);

            $this->carritoModel->añadirLibros($request->isbn, $request->unidades);

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

    public function eliminarLibros(Request $request) {
        try {
            $request->validate([//Validar datos
                "isbn" => "required",
                "unidades" => "required|min:1"
            ]);

            $this->carritoModel->eliminarLibros($request->isbn, $request->unidades);

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
}
