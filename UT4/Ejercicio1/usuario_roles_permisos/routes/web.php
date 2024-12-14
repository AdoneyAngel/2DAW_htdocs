<?php

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
})->name("principal");

Route::resource("usuarios", UsuarioController::class);
Route::resource("roles", RolController::class);
Route::resource("permisos", PermisoController::class);
