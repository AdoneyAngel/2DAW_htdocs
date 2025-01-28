<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar un listado de todos los usuarios
    public function index()
    {
        $listaUsuarios = Usuario::all();
        return new UsuarioCollection($listaUsuarios);
    }

    // Crear un usuario
    public function create()
    {
        $listaRoles = Rol::all();
        return view('usuarios.create', Compact('listaRoles'));
    }

    public function store(Request $request)
    {
        // Validación de formularios
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'usuario' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'roles' => 'required|array'
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->usuario = $request->usuario;
        $usuario->password = $request->password;
        $usuario->email = $request->email;
        $usuario->save();

        // Guardamos todos los roles sincronizando los registros.
        $resultado = $usuario->roles()->sync($request->roles);

        return redirect()->route('usuarios.index', Compact('resultado'));
    }

    // Editar un usuario
    public function edit(Usuario $usuario)
    {
        $listaRoles = Rol::all();
        return view('usuarios.edit', Compact('usuario'), Compact('listaRoles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->usuario = $request->usuario;
        $usuario->password = $request->password;
        $usuario->email = $request->email;
        $usuario->update();

        // Actualizamos todos los roles sincronizando los registros.
        $resultado = $usuario->roles()->sync($request->roles);

        return redirect()->route('usuarios.index', Compact('resultado'));
    }

    // Eliminar un usuario
    public function destroy(Usuario $usuario)
    {
        $usuario = Usuario::find($usuario->id);

        // Eliminamos todos los roles sincronizando los registros.
        $usuario->roles()->sync([]);

        $resultado = $usuario->delete();
        return redirect()->route('usuarios.index', Compact('resultado'));
    }

    // Mostrar un usuario específico
    public function show(Usuario $usuario)
    {
        return new UsuarioResource($usuario);
    }
}
