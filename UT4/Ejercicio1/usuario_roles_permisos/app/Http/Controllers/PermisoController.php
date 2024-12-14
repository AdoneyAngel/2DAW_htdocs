<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permiso::paginate(5);

        return view("permiso.permisos", compact("permisos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("permiso.crear");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "nombre"=>"required|min:1"
            ]);

            $nuevoPermiso = new Permiso();
            $nuevoPermiso->nombre = $request->nombre;
            $nuevoPermiso->save();

            return redirect()->route("permisos.index");

        } catch (\Exception $e) {
            return response("Ha habido un error al crear el tipo de permiso: ".$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $permiso = Permiso::find($id);

        return view("permiso.editar", compact("permiso"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $permiso = Permiso::find($id);

            $permiso->nombre = $request->nombre;
            $permiso->save();

            return redirect()->route("permisos.index");

        } catch (\Exception $err) {
            return response("Ha habido un error al actualizar el tipo de permiso: ".$err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $permiso = Permiso::find($id);
            $permiso->delete();

            return redirect()->route("permisos.index");

        } catch (\Exception $err) {
            return response("Ha habido un error al borrar el tipo de permiso: ".$err->getMessage());
        }
    }
}
