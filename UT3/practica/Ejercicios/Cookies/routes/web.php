<?php

use App\Http\Controllers\estilos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cookie;

Route::get('/', [estilos::class, "index"])->name("estilos");
Route::post("/guardar_cookie", [cookie::class, "guardar"]);
