<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Mostrar un listado de todos los roles de usuario
    public function index()
    {
        $listaRoles = Rol::all();
        return view('roles.index', Compact('listaRoles'));
    }

    // Crear un rol
    public function create()
    {
        $listaPermisos = Permiso::all();
        return view('roles.create', Compact('listaPermisos'));
    }

    public function store(Request $request)
    {
        // Validación de formularios
        $request->validate([
            'nombre' => 'required',
            'permisos' => 'required|array'
        ]);

        $rol = new Rol();
        $rol->nombre = $request->nombre;
        $rol->save();

        // Guardamos todos los permisos sincronizando los registros.
        $resultado = $rol->permisos()->sync($request->permisos);

        return redirect()->route('roles.index', Compact('resultado'));
    }

    // Editar un rol
    public function edit(int $id)
    {
        $rol = Rol::find($id);
        $listaPermisos = Permiso::all();
        return view('roles.edit', Compact('rol'), Compact('listaPermisos'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);
        $rol->nombre = $request->nombre;
        $rol->update();

        // Actualizamos todos los permisos sincronizando los registros.
        $resultado = $rol->permisos()->sync($request->permisos);

        return redirect()->route('roles.index', Compact('resultado'));
    }

    // Eliminar un rol
    public function destroy(int $id)
    {
        $rol = Rol::find($id);

        // Eliminamos todos los roles sincronizando los registros.
        $rol->permisos()->sync([]);

        $resultado = $rol->delete();
        return redirect()->route('roles.index', Compact('resultado'));
    }

    // Mostrar un rol específico
    public function show(int $id)
    {
        $rol = Rol::find($id);
        return view('roles.show', Compact('rol'));
    }
}
