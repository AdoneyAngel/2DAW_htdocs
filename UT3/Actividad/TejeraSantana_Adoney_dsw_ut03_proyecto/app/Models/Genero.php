<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Genero extends Model
{
    public static function getGeneros() {
        $contenidoFichero = Storage::disk("xml")->get("libros.xml");

        $contenidoXml = simplexml_load_string($contenidoFichero);

        $generosXml = $contenidoXml->xpath("//genero");

        $generos = [];

        foreach ($generosXml as $index => $genero) {
            //Comprobar si ya se ha agregado al array
            $agregado = false;
            foreach ($generos as $generoAgregado) {
                if ($generoAgregado["nombre"] == (string)$genero[0]) {
                    $agregado = true;
                }
            }

            if (!$agregado) {
                $generos[$index]["cod"] = $index;
                $generos[$index]["nombre"] = (string) $genero[0];
            }
        }

        return $generos;

    }

    public static function existeGenero($genero) {
        $contenidoFichero = Storage::disk("xml")->get("libros.xml");

        $contenidoXml = simplexml_load_string($contenidoFichero);

        $generosXml = $contenidoXml->xpath("//genero");

        foreach ($generosXml as $generoXml) {
            if ($generoXml == $genero) {
                return true;
            }
        }

        return false;
    }

    public static function getLibrosGenero($genero) {
        if (empty($genero)) {
            throw new \Exception("El género no es válido.");
        }
        if (!self::existeGenero($genero)) {
            throw new \Exception("El género no existe.");
        }

        $contenidoFichero = Storage::disk("xml")->get("libros.xml");
        $contenidoXml = simplexml_load_string($contenidoFichero);

        $librosDeGenero = $contenidoXml->xpath("//libro[genero='$genero']");

        $libros = [];

        foreach ($librosDeGenero as $libroXml) {
            $newLibro = [];

            foreach ($libroXml as $atributo => $valor) {
                $newLibro[(string) $atributo] = (string) $valor;
            }

            $libros[] = $newLibro;
        }

        return $libros;

    }
}
