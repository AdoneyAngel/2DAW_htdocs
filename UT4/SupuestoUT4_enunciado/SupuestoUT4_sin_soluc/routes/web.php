<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PublicacionController;

Route::get('/', function () {
    return view('principal');
});

// Definir rutas
Route::resource("usuarios", UsuarioController::class);
Route::resource("publicaciones", PublicacionController::class);
