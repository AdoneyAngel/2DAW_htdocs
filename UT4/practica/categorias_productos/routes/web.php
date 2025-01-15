<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
});

Route::get("/login", [UsuarioController::class, "loginView"])->name("loginView");
Route::post("/login", [UsuarioController::class, "login"])->name("login");

Route::resource("categorias", CategoriaController::class);
Route::get("/categorias/{id}/productos", [CategoriaController::class, "productos"])->name("categorias.productos");
