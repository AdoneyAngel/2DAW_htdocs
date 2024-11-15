<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    private $libroModel;
    private $carritoModel;

    public function __construct() {
        $this->libroModel = new Libro();
        $this->carritoModel = new Carrito();
    }

    public function cargarLibros() {
        $libros = $this->libroModel->getLibros();

        if ($libros) {
            //Buscar los libros que ya están en el carrito para contarlos en "unidades"
            $carrito = $this->carritoModel->getCarrito();

            foreach($libros as $libroIndex => $libro) {
                //Buscar en el carrito si existe este libro
                $unidades = 0;

                foreach($carrito as $libroCarrito) {
                    if ($libroCarrito["isbn"] == $libro["isbn"]) {
                        $unidades = $libroCarrito["unidades"];
                    }
                }

                $libro["unidades"] = $unidades;

                $libros[$libroIndex] = $libro;
            }

            return response(json_encode($libros));
        }
    }

    public function cargarGeneroLibros ($genero) {
        if (empty($genero)) {
            return response(json_encode([
                "respuesta" => false,
                "error" => "Párametros faltantes"
            ]));
        }

        try {
            $libros = Libro::getLibrosGenero($genero);

            return response(json_encode($libros));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }
}
