<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    // Mostrar un listado de todos las publicaciones
    public function index()
    {
        $listaPublicaciones = Publicacion::all();

        return view("publicaciones.index", compact("listaPublicaciones"));

    }

    // Crear una publicacion
    public function create()
    {
        $listaUsuarios = Usuario::all();

        return view("publicaciones.create", compact("listaUsuarios"));
    }

    public function store(Request $request)
    {
        // Validación de datos
       $request->validate([
            "nombre" => "required",
            "descripcion" => "required",
            "fecha" => "required",
            "usuario" => "required",
            "url" => "required"
    ]);

        // Lógica de guardado
        $nuevaPublicacion = new Publicacion();

        $nuevaPublicacion->Nombre = $request->nombre;
        $nuevaPublicacion->Descripcion = $request->descripcion;
        $nuevaPublicacion->Fecha_Publicacion = $request->fecha;
        $nuevaPublicacion->Usuario_ID = $request->usuario;
        $nuevaPublicacion->URL_Archivo = $request->url;

        $nuevaPublicacion->save();

        return redirect()->route("publicaciones.index");
    }

    // Editar una publicación
    public function edit(int $id)
    {
        $publicacion = Publicacion::find($id);
        $listaUsuarios = Usuario::all();

        return view("publicaciones.edit", compact("publicacion"), compact("listaUsuarios"));

    }

    // Actulizar datos de una publicación
    public function update(Request $request, $id)
    {
       // Validación de datos
       $request->validate([
            "nombre" => "required",
            "descripcion" => "required",
            "fecha" => "required",
            "usuario" => "required",
            "url" => "required"
       ]);

       // Lógica de guardado
       if (Publicacion::find($id)) {
        $publicacion = Publicacion::find($id);

        $publicacion->Nombre = $request->nombre;
        $publicacion->Descripcion = $request->descripcion;
        $publicacion->Fecha_Publicacion = $request->fecha;
        $publicacion->Usuario_ID = $request->usuario;
        $publicacion->URL_Archivo = $request->url;

        $publicacion->save();

        return redirect()->route("publicaciones.index");

       }
    }

    // Eliminar una publicación
    public function destroy(int $id)
    {
        $publicacion = Publicacion::find($id);
        $publicacion->delete();

        return redirect()->route("publicaciones.index");
    }

    // Mostrar una publicación
    public function show(int $id)
    {
        $publicacion = Publicacion::find($id);
        $usuario = $publicacion->usuario;
        $comentarios = $publicacion->comentarios;

        return view("publicaciones.show", [
            "publicacion"=>$publicacion,
            "usuario" => $usuario,
            "comentarios" => $comentarios
        ]);

    }
}
