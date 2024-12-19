<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\productoController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Usuario
Route::post("/login", [UsuariosController::class, "login"])->name("login");
Route::get("/isLogged", [UsuariosController::class, "isLogged"])->name("isLogged");
Route::get("/loginView", [UsuariosController::class, "loginView"])->name("loginView");

//Categoria
Route::resource("categorias", categoriaController::class);
Route::get("/categorias/{id}/productos", [categoriaController::class, "listaProductos"]);

//Producto
Route::resource('productos', productoController::class);
