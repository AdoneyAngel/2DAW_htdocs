<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Libro;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function cargarGeneros() {
        try {
            $generos = Genero::getGeneros();

            return response(json_encode($generos));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
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
