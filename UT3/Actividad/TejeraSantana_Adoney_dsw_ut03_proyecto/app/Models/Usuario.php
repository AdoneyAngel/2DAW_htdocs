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

            if (strlen(trim($lineaDividida[0])) == 0) {
                continue;
            }

            $acceso = [
                "idsesion" => $lineaDividida[0],
                "usuario" => $lineaDividida[1],
                "inicio" => $lineaDividida[2],
                "fin" => trim($lineaDividida[3])
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
            $idsesion = self::generarCodigo();

            $dataString = (string) "$idsesion#$usuario#$hora#";

            $rutaFicheroAccesos = Storage::disk("datos")->path("info_accesos.dat");

            $ficheroAccesos = fopen($rutaFicheroAccesos, "a");

            fwrite($ficheroAccesos, $dataString);

            fclose($ficheroAccesos);

            return $idsesion;

        } else {
            throw new \Exception("Sesion no iniciada");
        }
    }

    public static function guardarfinSesion() {
        if (!self::validarInfoAccesos()) {//Si no se ha abierto una sesión, no puede guardarse su cierre
            throw new \Exception("No hay sesiones creadas");
        }

        $hora = date("Y:m:d H:i:s");

        if (Session::has("Usuario") && Session::has("IdSesion")) {

            $accesos = self::getAccesos();//Se recorre todos los accesos para buscar el acceso del codigo actual

            foreach ($accesos as $index => $acceso) {
               if ($acceso["idsesion"] == Session::get("IdSesion")) {
                    $accesos[$index]["fin"] = $hora;
               }
            }

            self::guardarFicheroArray($accesos);

            return true;

        } else {
            throw new \Exception("Sesion no iniciada");
        }
    }

    private static function guardarFicheroArray($accesos) {
        $rutaFicheroAccesos = Storage::disk("datos")->path("info_accesos.dat");
        $fichero = fopen($rutaFicheroAccesos, "w");

        try {
            $dataString = "";

            foreach ($accesos as $acceso) {
                $dataString .= $acceso["idsesion"]."#".$acceso["usuario"]."#".$acceso["inicio"]."#".$acceso["fin"]."\n";
            }

            fwrite($fichero, $dataString);

        } catch (\Exception $err) {
            throw new \Exception($err);

        } finally {
            fclose($fichero);
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
