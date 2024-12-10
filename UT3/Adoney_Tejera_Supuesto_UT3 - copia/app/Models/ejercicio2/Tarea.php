<?php

namespace App\Models\ejercicio2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Tarea extends Model
{
    public static function getTareas() {
        if (Session::has("tareas")) {
            $tareas = Session::get("tareas");

            return $tareas;

        } else {
            return [];
        }
    }

    public static function agregar($nombre, $descripcion) {
        $tareas = self::getTareas();

        if (!empty($nombre) && !empty($descripcion)) {
            $tareas[] = [
                "nombre" => $nombre,
                "descripcion" => $descripcion
            ];

            Session::put("tareas", $tareas);

            return $tareas;

        } else {
            throw new \Exception("Faltan parámetros");
        }
    }
}
