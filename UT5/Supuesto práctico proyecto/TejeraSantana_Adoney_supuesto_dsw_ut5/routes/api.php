<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\EstadisticaClienteController;
use App\Http\Controllers\PerfilUsuarioController;
use App\Http\Controllers\PlanNutricionalController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\TipoMusculoController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/registrar", [AuthController::class, "registrar"]);

Route::group(["prefix" => "adoneytj", "middleware" => "auth:sanctum"], function () {
    Route::apiResource("usuarios", UsuarioController::class);
    Route::apiResource("tipos_usuarios", TipoUsuarioController::class);
    Route::apiResource("suscripciones", SuscripcionController::class);
    Route::apiResource("estadisticas_cliente", EstadisticaClienteController::class);
    Route::apiResource("perfiles_usuario", PerfilUsuarioController::class);
    Route::apiResource("planes_nutricionales", PlanNutricionalController::class);
    Route::apiResource("tipos_musculo", TipoMusculoController::class);
    Route::apiResource("ejercicios", EjercicioController::class);
});
