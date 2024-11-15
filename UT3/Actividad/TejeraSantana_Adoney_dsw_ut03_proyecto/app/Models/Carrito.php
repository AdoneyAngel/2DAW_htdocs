<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Carrito extends Model
{
    public function getCarrito() {
        if (Session::has("Carrito")) {
            return Session::get("Carrito");
        }
    }

    public function añadirLibros($isbn, $unidades) {
        if (!empty($isbn) && !empty($unidades) && $unidades > 0) {
            $carrito = [];

            //Comprobar que el libro existe
            if (!Libro::existeLibro($isbn)) {
                throw new \Exception("El libro indicado no existe");
            }

            if (Session::has("Carrito")) {
                $carrito = Session::get("Carrito");
                $carrito = Session::get("Carrito");
            }

            //Buscar si ya está en el carrito
            $libroEnCarrito = false;
            for ($itemIndex = 0; $itemIndex<count($carrito); $itemIndex++) {
                if ($carrito[$itemIndex]["isbn"] == $isbn) {
                    $libroEnCarrito = true;
                    $carrito[$itemIndex]["unidades"] += $unidades;
                }
            }

            if (!$libroEnCarrito) {
                $carrito[] = [
                    "isbn" => $isbn,
                    "unidades" => $unidades
                ];
            }

            Session::put("Carrito", $carrito);

            return true;

        }

        throw new \Exception("Parámetros inválidos");
    }
}
