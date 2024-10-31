<?php

use App\Http\Controllers\preferencias;
use App\Http\Controllers\Sesion;
use Illuminate\Support\Facades\Route;

Route::get('/', [preferencias::class, "index"]);

Route::post("/sesion", [Sesion::class, "guardar"]);
Route::get("/sesion", [Sesion::class, "index"]);
Route::get("/borrar", [Sesion::class, "borrar"]);
