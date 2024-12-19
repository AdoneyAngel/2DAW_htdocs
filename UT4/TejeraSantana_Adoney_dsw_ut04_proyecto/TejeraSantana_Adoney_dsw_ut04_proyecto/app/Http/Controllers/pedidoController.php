<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class pedidoController extends Controller
{
    public function realizarPedido() {
        try {
            if (!UsuariosController::isLogged()) {
                throw new \Exception("Debe iniciar sesion para realizar la peticion");
            }

            $usuario = Usuario::find(Session::get("usuario"));

            $carrito = $usuario->productosCarrito;

            if (count($carrito)) {
                //Se crea el pedido
                $pedido = $usuario->pedidos()->create();

                foreach ($carrito as $productoCarrito) {
                    $pedido->productos()->attach($productoCarrito->producto, ["unidades"=>$productoCarrito->unidades]);
                }

                //Eliminar el registro del carrito
                $usuario->productosCarrito()->delete();

                return response(view("pedido.realizar", ["procesada" => true, "error" => false]));

            } else {
                return response(view("pedido.realizar", ["procesada" => false, "error" => false]));
            }

        } catch (\Exception $err) {
            return response(view("pedido.realizar", ["procesada" => false, "error" => "Ha habido un error de servidor: ".$err->getMessage()]));
        }
    }
}
