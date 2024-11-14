<?php

use App\Http\Controllers\peliculas;
use App\Http\Controllers\sessionController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [sessionController::class, "index"])->name("login");
Route::post("/login", [sessionController::class, "login"]);
Route::get("/logout", [sessionController::class, "logout"]);

Route::get("/", [peliculas::class, "index"])->name("main");
Route::get("/getPeliculas", [peliculas::class, "getPeliculas"]);
Route::get("/getPeliculasPagina/{pagina}", [peliculas::class, "getPeliculasPagina"]);
Route::get("/getNumeroPeliculas", [peliculas::class, "getNumeroPeliculas"]);
