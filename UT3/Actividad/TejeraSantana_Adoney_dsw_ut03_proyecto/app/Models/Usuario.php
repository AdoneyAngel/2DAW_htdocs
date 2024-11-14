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
}
