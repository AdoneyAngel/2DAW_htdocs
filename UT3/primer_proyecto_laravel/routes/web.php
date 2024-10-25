<?php

use App\Http\Controllers\UserProfile;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get("/", [UsuarioController::class, "index"]);
Route::get('/profile/{id}', [UserProfile::class, "index"])->name("profile");