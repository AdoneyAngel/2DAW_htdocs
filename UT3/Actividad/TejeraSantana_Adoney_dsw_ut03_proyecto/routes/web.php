<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Principal');
});

Route::get("/isLogged", [UsuarioController::class, "isLogged"]);
Route::post("/login", [UsuarioController::class, "login"]);
Route::get("/logout", [UsuarioController::class, "logout"]);

Route::get("/cargarLibros", [LibroController::class, "cargarLibros"]);
