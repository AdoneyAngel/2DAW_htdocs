<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = Usuario::paginate(15);

        return view("usuario.usuarios", compact("usuarios"));
    }

    public function create() {
        $roles = Rol::all();

        return view("usuario.crear", compact("roles"));
    }

    public function store(Request $request) {
        try {
            $request->validate([
                "nombre" => "required|min:1",
                "apellidos" => "required|min:1",
                "email" => "required|email|min:1",
                "password" => "required|min:1",
                "rol"=>"required|min:1"
            ]);

            $nuevoUsuario = new Usuario();
            $nuevoUsuario->nombre = $request->nombre;
            $nuevoUsuario->apellidos = $request->apellidos;
            $nuevoUsuario->email = $request->email;
            $nuevoUsuario->password = $request->password;
            $nuevoUsuario->save();

            return redirect()->route("usuarios.index");

        } catch (\Exception $err) {
            return response("Error al crear usuario: ".$err->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $usuario = Usuario::find($id);
            $usuario->delete();

            return response("Eliminado con exito");

        } catch (\Exception $err) {
            return response("Error al borrar usuario: ".$err->getMessage());
        }

    }

    public function show($id) {
        try {
            $usuario = Usuario::find($id);
            return view("usuario.mostrar", compact("usuario"));

        } catch (\Exception $err) {
            return response("Ha ocurrido un error al buscar usuario: ".$err->getMessage());
        }
    }

    public function edit($id) {
        try {
            $usuario = Usuario::find($id);
            $roles = Rol::all();

            return view("usuario.editar", compact("usuario"), compact("roles"));

        } catch (\Exception $err) {
            return response("Ha ocurrido un error al editar usuario: ".$err->getMessage());
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                "nombre" => "required|min:1",
                "apellidos" => "required|min:1",
                "email" => "required|email",
                "password" => "required|min:1"
            ]);

            $usuario = Usuario::find($id);
            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = $request->password;
            $usuario->save();

            return redirect()->route("usuarios.index");

        } catch (\Exception $err) {
            return response("Ha ocurrido un error al actualizar usuario: ".$err->getMessage());
        }
    }
}
