<?php

use App\Http\Controllers\formulario;
use App\Http\Controllers\principal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/seleccionar", [formulario::class, "index"])->name("seleccion");

Route::post("/principal", [principal::class, "subir"]);
Route::get("/principal", [principal::class, "index"]);
Route::get("/logout", [principal::class, "logout"]);
