<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Carrito extends Model
{
    public function getCarrito() {
        if (Session::has("Carrito")) {
            return Session::get("Carrito");

        } else {
            return false;
        }
    }

    public function añadirLibros($isbn, $unidades) {
        //Comprobar que tiene la sesion iniciada
        if (!Session::has("Usuario")) {
            throw new \Exception("Debe iniciar sesion antes de añadir libros");
        }

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

        throw new \Exception("Parámetros inválidos.");
    }

    public function eliminarLibros($isbn, $unidades) {
        //Comprobar que tiene la sesion iniciada
        if (!Session::has("Usuario")) {
            throw new \Exception("Debe iniciar sesion antes de añadir libros.");
        }
        if (!Session::has("Carrito")) {
            throw new \Exception("No existe carrito, debe iniciar sesión.");
        }
        if (count(Session::get("Carrito")) <= 0) {
            throw new \Exception("El carrito está vacío.");
        }

        if (!empty($isbn) && !empty($unidades) && $unidades > 0) {
            $carrito = Session::get("Carrito");

            //Comprobar que el libro existe
            if (!Libro::existeLibro($isbn)) {
                throw new \Exception("El libro indicado no existe.");
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
                throw new \Exception("El libro no se encuentra en el carrito.");
            }

            Session::put("Carrito", $carrito);

            return true;

        }

        throw new \Exception("Parámetros inválidos.");
    }

    public static function vaciar() {
        if (Session::has("Carrito")) {
            Session::put("Carrito", []);
        }
    }
}
