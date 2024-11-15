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
        $validateRequest = $request->validate([
            "isbn" => "required",
            "unidades" => "required|min:1"
        ]);

        if (!$validateRequest) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Parámetros inválidos"
            ]));
        }

        try {
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
        $validateRequest = $request->validate([
            "isbn" => "required",
            "unidades" => "required|min:1"
        ]);

        if (!$validateRequest) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Parámetros inválidos"
            ]));
        }

        try {
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
