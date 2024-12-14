<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Rol::paginate(5);

        return view("rol.roles", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permiso::all();

        return view("rol.crear", compact("permisos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "nombre"=>"required|min:1",
                "permisos"=>"required|min:1"
            ]);

            $nuevoRol = new Rol();
            $nuevoRol->nombre = $request->nombre;
            $nuevoRol->save();

            //Una vez ya existe el rol, se le asignan los permisos
            $nuevoRol->permisos()->attach($request->permisos);
            $nuevoRol->save();

            return redirect()->route("roles.index");

        } catch(\Exception $err) {
            return response("Ha habido un error al crear el rol: ".$err->getMessage());
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
        $rol = Rol::find($id);
        $permisos = Permiso::all();

        return view("rol.editar", compact("rol"), compact("permisos"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                "nombre"=>"required|min:1",
                "permisos"=>"required|min:1"
            ]);

            $rol = Rol::find($id);
            $rol->nombre = $request->nombre;
            $rol->permisos()->sync($request->permisos);//Sustituye la reloacion de "permisos" que tenía por el nuevo array de ID's de permisos

            return redirect()->route("roles.index");


        } catch (\Exception $err) {
            return response("Ha habido un error al actualizar el rol: ".$err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $rol = Rol::find($id);
            $rol->permisos()->detach();//De esta forma se eliminar relacines con "permisos"
            $rol->delete();

            return redirect()->route("roles.index");

        } catch (\Exception $err) {
            return response("Ha habido un error al eliminar el rol: ".$err->getMessage());
        }
    }
}
