<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = Usuario::all();

        return response($usuarios);
    }

    public function show($id) {
        $usuariosFiltrado = Usuario::where("id", $id)->get();

        return response($usuariosFiltrado);
    }
}
