<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Libro extends Model
{
    public function getLibros() {
        $contenidoFichero = Storage::disk("xml")->get("libros.xml");

        $librosXml = simplexml_load_string($contenidoFichero)->xpath("//libro");

        $libros = [];

        foreach ($librosXml as $libroXml) {
            $libro = [];

            foreach ($libroXml as $atributo => $valor) {
                $atributo = (string) $atributo;
                $valor = (string) $valor;

                $libro[$atributo] = $valor;
            }

            $libros[] = $libro;
        }

        return $libros;

    }

    public static function getLibroDatos($isbn):array {
        $isbn = trim($isbn);
        if (empty($isbn)) {
            throw new \Exception("Parámetros inválidos");
        }
        if (!self::existeLibro($isbn)) {
            throw new \Exception("No existe el libro");
        }

        $contenidoFichero = Storage::disk("xml")->get("libros.xml");
        $contenidoXml = simplexml_load_string($contenidoFichero);

        $libroXml = $contenidoXml->xpath("//libro[isbn='$isbn']");

        $libro = [];

        foreach ($libroXml[0] as $atributo => $valor) {
            $libro[$atributo] = (string) $valor;
        }

        return $libro;
    }

    public static function existeLibro($isbn) {
        $contenidoFichero = Storage::disk("xml")->get("libros.xml");

        $librosXml = simplexml_load_string($contenidoFichero)->xpath("//libro[isbn='$isbn']");

        if (count($librosXml) > 0) {
            return true;
        }

        return false;
    }
}
