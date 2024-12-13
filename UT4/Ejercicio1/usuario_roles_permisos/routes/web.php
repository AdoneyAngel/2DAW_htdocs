<?php

use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
})->name("principal");

Route::resource("usuarios", Usuario::class);
