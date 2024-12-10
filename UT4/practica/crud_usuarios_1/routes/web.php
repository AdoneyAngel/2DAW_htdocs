<?php

use App\Http\Controllers\UsuaroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("usuarios", UsuaroController::class);
