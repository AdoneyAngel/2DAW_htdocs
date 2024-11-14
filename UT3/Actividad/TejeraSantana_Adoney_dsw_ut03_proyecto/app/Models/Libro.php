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
}
