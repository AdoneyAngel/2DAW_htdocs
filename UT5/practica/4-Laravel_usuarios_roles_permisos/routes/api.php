<?php

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(["prefix" => "v1"], function () {
    Route::apiResource("usuarios", UsuarioController::class);
    Route::apiResource("permisos", PermisoController::class);
});
