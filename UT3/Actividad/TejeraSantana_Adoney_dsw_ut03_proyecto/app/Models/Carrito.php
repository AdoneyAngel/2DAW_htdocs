<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Carrito extends Model
{
    public function getCarrito() {
        if (Session::has("Carrito")) {
            return Session::get("Carrito");
        }
    }
}
