<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Usuario extends Model
{
    public function getUsuarios() {
        $accesoFichero = Storage::disk("xml")->get("configuracion.xml");

        $accesoFichero = simplexml_load_string($accesoFichero);

        $usuarios = [
            [
                "usuario" => (string) $accesoFichero->usuario,
                "clave" => (string) $accesoFichero->clave
            ]
        ];

        return $usuarios;
    }

    public static function getUsuario() {
        if (Session::has("Usuario")) {
            return Session::get("Usuario");
        }

        return false;
    }

    public static function guardarInicioSesion() {
        if (!self::validarInfoAccesos()) {
            self::crearInfoAcceso();
        }

        $hora = date("Y:m:d H:i:s");

        if (Session::has("Usuario")) {
            $usuario = Session::get("Usuario");

            $dataString = (string) $usuario."#".$hora."#";

            $rutaFicheroAccesos = Storage::disk("datos")->path("info_accesos.dat");

            $ficheroAccesos = fopen($rutaFicheroAccesos, "a");

            fwrite($ficheroAccesos, $dataString);

            fclose($ficheroAccesos);

            return true;

        } else {
            throw new \Exception("Sesion no iniciada");
        }
    }

    public static function guardarCierreSesion() {
        if (!self::validarInfoAccesos()) {//Si no se ha abierto una sesión, no puede guardarse su cierre
            throw new \Exception("No hay sesiones creadas");
        }

        $hora = date("Y:m:d H:i:s");

        if (Session::has("Usuario")) {
            $dataString = (string) $hora."\n";

            $rutaFicheroAccesos = Storage::disk("datos")->path("info_accesos.dat");

            $ficheroAccesos = fopen($rutaFicheroAccesos, "a");

            fwrite($ficheroAccesos, $dataString);

            fclose($ficheroAccesos);

            return true;

        } else {
            throw new \Exception("Sesion no iniciada");
        }
    }

    private static function crearInfoAcceso() {
        $rutaFichero = Storage::disk("datos")->path("info_accesos.dat");

        $fichero = fopen($rutaFichero, "w");
        fclose($fichero);
    }

    private static function validarInfoAccesos() {
        if (!Storage::disk("datos")->exists("info_accesos.dat")) {
            return false;
        }

        return true;
    }
}
