<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(["prefix" => "v1"], function() {
    Route::apiResource("clientes", ClienteController::class);
    Route::apiResource("facturas", FacturaController::class);
});
