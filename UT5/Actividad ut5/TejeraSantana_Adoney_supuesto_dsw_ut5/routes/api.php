<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return true;
})->middleware('auth:sanctum');

Route::get("/registrar", [UsuarioController::class, "registrar"]);

Route::group(["middleware" => "auth:sanctum"], function() {
    Route::apiResource("usuarios", UsuarioController::class);

});
