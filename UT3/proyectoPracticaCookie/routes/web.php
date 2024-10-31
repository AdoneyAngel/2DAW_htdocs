<?php

use App\Http\Controllers\myCookie;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post("fuente", [myCookie::class, "cambiarFuente"])->name('fuente');
Route::get("fuente", [myCookie::class, "cambiarFuente"])->name('fuente');
