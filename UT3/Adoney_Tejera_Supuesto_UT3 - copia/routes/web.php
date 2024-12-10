<?php

use App\Http\Controllers\ejercicio1\productoController;
use App\Http\Controllers\ejercicio3\productoControllerEj3;
use App\Http\Controllers\ejercicio2\tareaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/productos", [productoController::class, "index"]);
Route::get("/productos/{id}", [productoController::class, "detalles"]);

Route::get("/tareas", [tareaController::class, "index"]);
Route::get("/tareas/agregar/nombre&descripcion", [tareaController::class, "agregar"]);

Route::get("/listaProductos", [productoControllerEj3::class, "index"]);
