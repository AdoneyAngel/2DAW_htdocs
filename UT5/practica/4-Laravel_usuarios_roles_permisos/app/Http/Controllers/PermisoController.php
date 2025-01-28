<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermisoStore;
use App\Http\Resources\PermisoCollection;
use App\Http\Resources\PermisoResource;
use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    // Mostrar un listado de todos los permisos.
    public function index()
    {
        $listaPermisos = Permiso::all();

        return new PermisoCollection($listaPermisos);
    }

    // Crear un permiso
    public function create()
    {
        return view('permisos.create');
    }

    public function store(PermisoStore $request)
    {
        // Validación de formularios
        $permiso = new Permiso();
        $permiso->nombre = $request->nombre;
        $resultado = $permiso->save();

        return redirect()->route('permisos.index', Compact('resultado'));
    }

    // Editar un permiso
    public function edit(Permiso $permiso)
    {
        return view('permisos.edit', Compact('permiso'));
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::find($id);
        $permiso->nombre = $request->nombre;

        $resultado = $permiso->update();

        return redirect()->route('permisos.index', Compact('resultado'));
    }

    // Eliminar un permiso
    public function destroy(int $id)
    {
        $permiso = Permiso::find($id);
        $resultado = $permiso->delete();
        return redirect()->route('permisos.index', Compact('resultado'));
    }

    // Mostrar un rol específico
    public function show(Permiso $permiso)
    {
        return new PermisoResource($permiso);
    }
}

