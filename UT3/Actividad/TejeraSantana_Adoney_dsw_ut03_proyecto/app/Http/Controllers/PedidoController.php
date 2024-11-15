<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PedidoController extends Controller
{
    public function procesarPedido() {
        $viewMessage = "";

        if (Pedido::existeCarrito()) {
            try {
                Pedido::procesarPedido();

                $viewMessage = "Pedido realizado con éxito. Se enviará un correo de confirmación.";

            } catch (\Exception $err) {
                $viewMessage = "Ha ocurrido un error durante el proceso: ".$err->getMessage();
            }

        } else {
            $viewMessage = "El pedido no se puede realizar. El carrito está vacío...";
        }

        return view("Procesar_pedido", ["message" => $viewMessage]);
    }

    public function obtenerPedidos() {
        try {
            $pedidos = Pedido::getPedidos();

            $pedidosResponse = [];

            foreach ($pedidos as $pedido) {
                $libro = Libro::getLibroDatos($pedido["isbn"]);
                $libroPedido = [];

                $libroPedido["fecha"] = $pedido["fecha"];
                $libroPedido["unidades"] = str_replace("\n", "",$pedido["unidades"]);
                $libroPedido["cod"] = $pedido["cod"];
                $libroPedido["usuario"] = Session::get("Usuario");

                foreach ($libro as $atributo => $valor) {
                    $libroPedido[$atributo] = $valor;
                }

                $pedidosResponse[] = $libroPedido;
            }

            return response(json_encode($pedidosResponse));

        } catch (\Exception $err) {
            return response(json_encode([
                "respuesta" => false,
                "error" => $err->getMessage()
            ]));
        }
    }
}
