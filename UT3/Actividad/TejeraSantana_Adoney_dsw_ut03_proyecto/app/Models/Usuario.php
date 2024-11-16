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

    public static function getAccesos() {
        self::validarInfoAccesos();

        $accesos = [];

        $rutaFichero = Storage::disk("datos")->path("info_accesos.dat");

        $fichero = fopen($rutaFichero, "r");

        while ($linea = fgets($fichero)) {

            $lineaDividida = explode("#", $linea);

            if (empty($lineaDividida)) {
                continue;
            }

            $acceso = [
                "codigo" => $lineaDividida[0],
                "usuario" => $lineaDividida[1],
                "fecha_acceso" => $lineaDividida[2],
                "fecha_cierre" => $lineaDividida[3]
            ];

            $accesos[] = $acceso;

            if (feof($fichero)) {
                break;
            }
        }

        return $accesos;

    }

    public static function guardarInicioSesion() {
        if (!self::validarInfoAccesos()) {
            self::crearInfoAcceso();
        }

        $hora = date("Y:m:d H:i:s");

        if (Session::has("Usuario")) {
            $usuario = Session::get("Usuario");
            $codigoSesion = self::generarCodigo();

            $dataString = (string) "$codigoSesion#$usuario#$hora#";

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

    private static function generarCodigo() {
        self::validarInfoAccesos();

        $rutaFichero= Storage::disk("datos")->path("info_accesos.dat");

        $fichero = fopen($rutaFichero, "r");

        $ids = [];

        //Se carga todos los IDs
        while ($linea = fgets($fichero)) {
            $linea = trim($linea);
            $lineaDividida = explode("#", $linea);

            if (empty($linea)) {
                continue;
            }

            $idActual = $lineaDividida[0];

            $ids[] = $idActual;

            if (feof($fichero)) {
                break;
            }
        }

        $codigoRepetido = true;
        $nuevoCodigo = -1;

        while ($codigoRepetido) {
            $nuevoCodigo++;
            $codigoRepetido = false;

            if (in_array($nuevoCodigo, $ids)) {
                $codigoRepetido = true;
            }
        }

        return $nuevoCodigo;
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
