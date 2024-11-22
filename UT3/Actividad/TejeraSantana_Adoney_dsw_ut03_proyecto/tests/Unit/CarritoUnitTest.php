<?php

namespace Tests\Unit;

use App\Models\Carrito;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CarritoUnitTest extends TestCase
{
    public function test_getCarrito() {
        $model = new Carrito();

        $sinCarrito = $model->getCarrito();
        $this->assertEquals(false, $sinCarrito);

        Session::put("Carrito", ["isbn"=>3,"unidades"=>5]);

        $carrito = $model->getCarrito();
        $this->assertEquals([
            "isbn" => 3,
            "unidades"=>5
        ], $carrito);
    }

    public function test_añadirLibros() {
        $model = new Carrito();

        Session::put("Usuario", "test");
        $model->añadirLibros(1,2);
        $model->añadirLibros(1,2);
        $model->añadirLibros(2,5);
        $carrito = $model->getCarrito();

        $this->assertEquals([
            ["isbn"=>1,"unidades"=>4],
            ["isbn"=>2,"unidades"=>5]
        ], $carrito);

        //Comprobar excepciones
        Session::flush();
        $this->expectException(\Exception::class);

        $model->añadirLibros(1, 3);
        $model->añadirLibros("","");

        Session::put("Usuario", "testExcepction");
        $model->añadirLibros(54,3);

        $carritoVacio = $carrito->getCarrito();
        $this->assertEquals($carritoVacio, []);
    }

    public function test_eliminarLibros() {
        $model = new Carrito();

        Session::put("Usuario", "test");

        $model->añadirLibros(1, 5);
        $model->añadirLibros(3, 2);
        $model->añadirLibros(2, 4);

        $model->eliminarLibros(1,2);
        $model->eliminarLibros(2,5);

        $carrito = $model->getCarrito();

        $this->assertEquals([
            ["isbn"=>1, "unidades"=>3],
            ["isbn"=>3, "unidades"=>2]
        ], $carrito);

        $this->expectException(\Exception::class);
        $model->eliminarLibros(7, 3);

        Session::flush();
        $model->eliminarLibros(1, 3);
    }

    public function test_vaciar() {
        $model = new Carrito();

        Session::put("Usuario", "test");

        $model->añadirLibros(1, 4);
        $model->vaciar();

        $carritoVacio = $model->getCarrito();

        $this->assertEquals([], $carritoVacio);
    }
}
