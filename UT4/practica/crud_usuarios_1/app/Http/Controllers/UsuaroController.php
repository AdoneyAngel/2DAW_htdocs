<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuaroController extends Controller
{
    public function index() {
        $usuarios = Usuario::paginate(4);

        return view("principal", ["usuarios"=> $usuarios]);
    }

    public function show($id) {
        $usuarioEncontrado = Usuario::find($id);

        if ($usuarioEncontrado) {
            return view("detalles", ["usuario"=>$usuarioEncontrado]);

        } else {
            return response("No se ha encontrado el usuario");
        }

    }

    public function edit(Usuario $usuario) {

        if ($usuario) {
            return view("editar", ["usuario"=>$usuario]);

        } else {
            return response("No se ha encontrado el usuario");
        }
    }

    public function update(Request $request) {
        $request->validate([
            "id"=>"required|min:1",
            "nombre"=>"required|min:1",
            "apellidos"=>"required|min:1",
            "mail"=>"required|min:1"
        ]);

        $usuario = Usuario::find($request->id);
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->mail = $request->mail;
        $usuario->save();

        return redirect("/usuarios");
    }

    public function destroy($id) {
        $usuario = Usuario::find($id);

        if ($usuario) {
            Usuario::destroy($id);
        }

        return redirect("/usuarios");

    }

    public function create() {
        return view("crear");
    }

    public function store(Request $request) {
        $request->validate([
            "nombre"=>"required",
            "apellidos"=>"required",
            "mail"=>"required"
        ]);

        $nuevoUsuario = new Usuario();
        $nuevoUsuario->nombre = $request->nombre;
        $nuevoUsuario->apellidos = $request->apellidos;
        $nuevoUsuario->mail = $request->mail;
        $nuevoUsuario->save();

        return redirect("/usuarios");

    }
}
