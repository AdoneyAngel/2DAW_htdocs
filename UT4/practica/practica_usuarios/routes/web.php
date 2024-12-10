<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get("/", [UsuarioController::class, "index"]);
Route::get("/{id}", [UsuarioController::class, "show"]);
