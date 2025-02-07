<?php

namespace App\Http\Controllers;

use DateTime;

class Utilities extends Controller
{
    public static function validarFechas($inicio, $fin): bool {
        $fechaInicio = new DateTime($inicio);
        $fechaFin = new DateTime($fin);

        if ($fechaInicio && $fechaFin) {
            if ($fechaInicio < $fechaFin) {
                return true;
            }
        }

        return false;
    }

    public static function validarFechaNacimiento($fechaNacimiento) {
        $fechaNacimiento = new DateTime($fechaNacimiento);

        if ($fechaNacimiento) {
            if ($fechaNacimiento < new DateTime("now")) {
                return true;
            }
        }

        return false;
    }

    public static function validarFechaRegistro($fechaRegistro) {
        $fechaRegistro = new DateTime($fechaRegistro);

        if ($fechaRegistro) {
            if ($fechaRegistro <= new DateTime("now")) {
                return true;
            }
        }

        return false;
    }

    public static function validarFechaEdad($fecha, $edad) {
        $fecha = new DateTime($fecha);

        if ($fecha) {
            if ($fecha <= new DateTime("-".$edad)) {
                return true;
            }
        }

        return false;
    }

    public static function calcEdad($fecha) {
        if (!new DateTime($fecha)) {
            return false;
        }

        $fecha = strtotime($fecha);
        $fechaActual = strtotime("now");

        $edad = ($fechaActual-$fecha)/(60*60*24*365);

        return $edad;
    }

}
