<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PedidoFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_procesar_pedido() {
        //No se puede procesar un pedido sin carrito
        $pedidoSinCarrito = $this->get("/procesar_pedido");
        $pedidoSinCarrito->assertSee("El pedido no se puede realizar. El carrito está vacío...");

        //Se borra el contenido del fichero de pedidos para comprobar que se escribe algo
        $fichero = fopen(Storage::disk("datos")->path("pedidos.dat"), "w");
        fwrite($fichero, "");
        fclose($fichero);

        //Se loguea y se agrega algo al carrito
        $this->post("/login", ["usuario"=>"root@email.com","clave"=>"1234"]);
        $this->post("/agregarLibros", ["isbn"=>1,"unidades"=>3]);

        $pedidoConCarrito = $this->get("/procesar_pedido");
        $pedidoConCarrito->assertSee("Pedido realizado con éxito. Se enviará un correo de confirmación.");

        $this->assertEquals([], Session::get("Carrito"));//Al hacer el pedido el carrito debe vaciarse

        //Comprobar si añade el pedido al fichero
        $fechaActual = date("Y:m:d H:i:s");
        $contenidoFichero = Storage::disk("datos")->get("pedidos.dat");
        $this->assertEquals("0#root@email.com#$fechaActual#1#3@", trim($contenidoFichero));
    }

    public function test_obtenerPedidos() {
        //Se borra el contenido del fichero de pedidos para comprobar que se escribe algo
        $fichero = fopen(Storage::disk("datos")->path("pedidos.dat"), "w");
        fwrite($fichero, "");
        fclose($fichero);

        //Se loguea y se agrega algo al carrito
        $fechaActual = date("Y:m:d H:i:s");
        $this->post("/login", ["usuario"=>"root@email.com","clave"=>"1234"]);
        $this->post("/agregarLibros", ["isbn"=>1,"unidades"=>3]);
        $this->get("/procesar_pedido");

        $pedidos = $this->get("/obtenerPedidos");
        $pedidos->assertJson([
            [
                "codpedido"=>0,
                "fechapedido"=>$fechaActual,
                "isbn"=>"1",
                "titulo"=>"Guía del Autoestopista Galático",
                "escritores"=>"Douglas Adams",
                "genero"=>"Comedia",
                "numpaginas"=>"257 pág.",
                "imagen"=>"img/autoestopista.jpg",
                "unidades"=>3
            ]
        ]);

    }

    public function test_cancelarPedido() {
        //No puede cancelar nada sin estar logueado
        $cancelarSinSesion = $this->post("/cancelarPedido", ["cod"=>54]);
        $cancelarSinSesion->assertJson([
            "respuesta"=>false,
            "error"=>"Debe iniciar sesión."
        ]);

        //No puede cancelar un pedido que no existe
        $this->post("/login", ["usuario"=>"root@email.com","clave"=>"1234"]);
        $cancelarNoExiste = $this->post("/cancelarPedido", ["cod"=>54]);
        $cancelarNoExiste->assertJson([
            "respuesta"=>false,
            "error"=>"No existe el pedido."
        ]);

        //Debe poder cancelar un pedido que SI existe
        $this->post("/agregarLibros", ["isbn"=>1,"unidades"=>15]);
        $this->get("/procesar_pedido");

        $cancelarExiste = $this->post("/cancelarPedido", ["cod"=>0]);
        $cancelarExiste->assertJson([
            "respuesta"=>true,
            "error"=>""
        ]);
    }
}
