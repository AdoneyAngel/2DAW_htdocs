<?php

use App\Http\Controllers\principal;
use Illuminate\Support\Facades\Route;

Route::get('/', [principal::class, "index"]);
