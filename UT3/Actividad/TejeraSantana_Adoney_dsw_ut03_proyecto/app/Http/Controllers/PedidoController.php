<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function procesarPedido() {
        return view("Procesar_pedido", ["message" => ""]);
    }
}
