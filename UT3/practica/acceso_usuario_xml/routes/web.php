<?php

use App\Http\Controllers\login;
use App\Http\Controllers\principal;
use Illuminate\Support\Facades\Route;

Route::get('/', [principal::class, "index"])->name("main");
Route::post("/info", [principal::class, "showInfo"])->name("info");

Route::get("/login", [login::class, "index"])->name("login");
Route::post("/login", [login::class, "login"]);
Route::get("/logout", [login::class, "logout"])->name("logout");
