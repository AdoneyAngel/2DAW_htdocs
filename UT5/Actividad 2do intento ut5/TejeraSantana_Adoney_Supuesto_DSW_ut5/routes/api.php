<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/registrar", [UsuarioController::class, "registrar"]);

Route::group(["middleware" => "auth:sanctum"], function() {
    Route::apiResource("usuarios", UsuarioController::class);
    Route::apiResource("categorias", CategoriaController::class);

});
