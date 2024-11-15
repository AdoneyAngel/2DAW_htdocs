<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Principal');
});

Route::get("/isLogged", [UsuarioController::class, "isLogged"]);
Route::post("/login", [UsuarioController::class, "login"]);
Route::get("/logout", [UsuarioController::class, "logout"]);
Route::get("/cargarUsuario", [UsuarioController::class,  "cargarUsuario"]);

Route::get("/cargarLibros", [LibroController::class, "cargarLibros"]);
Route::get("/cargarGeneroLibros/{genero}", [LibroController::class, "cargarGeneroLibros"]);

Route::get("/cargarCarrito", [CarritoController::class, "cargarCarrito"]);
Route::post("/agregarLibro", [CarritoController::class, "añadirLibros"]);

Route::get("/cargarGeneros", [GeneroController::class, "cargarGeneros"]);

Route::get("/procesar_pedido", [PedidoController::class, "procesarPedido"]);
