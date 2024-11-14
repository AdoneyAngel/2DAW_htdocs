<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Xml extends Model
{

    public static function getUsers(): array | null {
        $usersXml = Storage::disk("xml")->get("users.xml");//Se obtiene el contenido del fichero xml de usuarios

        $usersXmlContent = simplexml_load_string($usersXml);//Se carga los datos del xml (se transforma a un objeto manipulable)

        $users = $usersXmlContent->xpath("//user");//Se obtiene todos los usuarios (se obtiene todas las etiquetas "user")

        return $users;
    }

    public static function getPeliculas(): array | null {
        $peliculasXml = Storage::disk("xml")->get("peliculas.xml");

        $peliculasContenido = simplexml_load_string($peliculasXml);

        $peliculas = $peliculasContenido->xpath("//pelicula");

        return $peliculas;

    }
}
