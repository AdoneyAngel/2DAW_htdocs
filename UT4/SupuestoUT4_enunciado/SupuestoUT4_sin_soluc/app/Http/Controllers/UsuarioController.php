<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar un listado de todos los usuarios
    public function index()
    {
        $listaUsuarios = Usuario::all();

        return view("usuarios.index", compact("listaUsuarios"));
    }

    // Crear un usuario
    public function create()
    {
        return view("usuarios.create");
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            "nombre" => "required",
            "usuario" => "required",
            "password" => "required",
            "foto" => "required",
            "fecha" => "required",
            "email" => "required|email",
        ]);

        // Guardado de datos
        $nuevoUsuario = new Usuario();

        $nuevoUsuario->Nombre = $request->nombre;
        $nuevoUsuario->Nombre_Usuario = $request->usuario;
        $nuevoUsuario->Contraseña = $request->password;
        $nuevoUsuario->Foto_Perfil = $request->foto;
        $nuevoUsuario->Fecha_Registro = $request->fecha;
        $nuevoUsuario->Correo_Electronico = $request->email;
        $nuevoUsuario->save();

        return redirect()->route("usuarios.index");

    }

    // Editar un usuario
    public function edit(Usuario $usuario)
    {
        return view("usuarios.edit", compact("usuario"));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            "nombre" => "required",
            "usuario" => "required",
            "password" => "required",
            "foto" => "required",
            "fecha" => "required",
            "email" => "required|email",
        ]);

        // Lógica de guardado

        //Comprobar que el usuario existe
        if (Usuario::find($id)) {
            $usuario = Usuario::find($id);

            $usuario->Nombre = $request->nombre;
            $usuario->Nombre_Usuario = $request->usuario;
            $usuario->Contraseña = $request->password;
            $usuario->Foto_Perfil = $request->foto;
            $usuario->Fecha_Registro = $request->fecha;
            $usuario->Correo_Electronico = $request->email;
            $usuario->save();

            return redirect()->route("usuarios.index");
        }


    }

    // Eliminar un usuario
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route("usuarios.index");
    }

    // Mostrar un usuario
    public function show(Usuario $usuario)
    {
        $listaPublicaciones = $usuario->publicaciones;
        $listaComentarios = $usuario->comentarios;

        return view("usuarios.show",["usuario" => $usuario, "listaPublicaciones" => $listaPublicaciones, "listaComentarios" => $listaComentarios]);
    }
}
