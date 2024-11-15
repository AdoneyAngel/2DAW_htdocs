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
            }

            //Buscar si ya está en el carrito
            $libroEnCarrito = false;
            foreach ($carrito as $itemIndex => $item) {
                if ($item["isbn"] == $isbn) {
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

    public function eliminarLibros($isbn, $unidades) {
        if (!empty($isbn) && !empty($unidades) && $unidades > 0) {
            $carrito = [];

            //Comprobar que el libro existe
            if (!Libro::existeLibro($isbn)) {
                throw new \Exception("El libro indicado no existe");
            }

            if (Session::has("Carrito")) {
                $carrito = Session::get("Carrito");
            }

            //Buscar si ya está en el carrito
            $libroEnCarrito = false;
            foreach ($carrito as $itemIndex => $item) {
                if ($item["isbn"] == $isbn) {
                    $libroEnCarrito = true;
                    $carrito[$itemIndex]["unidades"] -= $unidades;

                    if ($carrito[$itemIndex]["unidades"] <= 0) {//Si al reducir el númreo llega a 0 o menos, este se elimina de la lista
                        unset($carrito[$itemIndex]);
                    }
                }
            }

            if (!$libroEnCarrito) {
                throw new \Exception("El libro no se encuentra en el carrito");
            }

            Session::put("Carrito", $carrito);

            return true;

        }

        throw new \Exception("Parámetros inválidos");
    }

    public static function vaciar() {
        if (Session::has("Carrito")) {
            Session::put("Carrito", []);
        }
    }
}
