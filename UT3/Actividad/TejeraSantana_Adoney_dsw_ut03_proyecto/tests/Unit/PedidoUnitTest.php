<?php

namespace Tests\Unit;

use App\Models\Carrito;
use App\Models\Pedido;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PedidoUnitTest extends TestCase
{
    public function test_procesarPedido() {
        $rutaFichero = Storage::disk("datos")->path("pedidos.dat");
        $fechaActual = date("Y:m:d H:i:s");
        Storage::disk("datos")->delete("pedidos.dat");//Se borra el fichero para las pruebas

        Session::put("Carrito", [["isbn"=>3,"unidades"=>1], ["isbn"=>1,"unidades"=>2]]);
        Session::put("Usuario", "test");

        Pedido::procesarPedido();

        //El fichero debe ser creado
        $this->assertFileExists($rutaFichero);

        //Debe añadirse la información
        $contenidoFichero = Storage::disk("datos")->get("pedidos.dat");

        $this->assertEquals("0#test#$fechaActual#3#1@\n1#test#$fechaActual#1#2@\n", $contenidoFichero);

        //Comprobar excepciones
        Session::flush();
        $this->expectException(\Exception::class);

        Pedido::procesarPedido();//No puede procesar pedido si no tiene usuario o carrito
    }

    public function test_getPedidos() {
        $fechaActual = date("Y:m:d H:i:s");
        Storage::disk("datos")->delete("pedidos.dat");

        Session::put("Usuario", "test");
        Session::put("Carrito", [["isbn"=>1,"unidades"=>4]]);

        //Comprobar que retorna un string vacio si no existe el fichero de datos
        $pedidosVacios = Pedido::getPedidos();
        $this->assertEquals([], $pedidosVacios);

        //Comprobar que los datos retornados son válidos
        Pedido::procesarPedido();
        $pedidos = Pedido::getPedidos();

        $this->assertEquals([[
            "codpedido"=>"0",
            "usuario"=>"test",
            "fechapedido"=>$fechaActual,
            "isbn"=>"1",
            "unidades"=>"4"]], $pedidos);
    }
}
