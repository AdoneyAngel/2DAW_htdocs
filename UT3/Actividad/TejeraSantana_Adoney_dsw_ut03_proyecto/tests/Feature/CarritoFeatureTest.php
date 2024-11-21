<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CarritoFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_cargarCarrito() {
        //Si no hay una sesión, no hay carrito por lo que debe retornar falso
        $carritoNoExiste = $this->get("/cargarCarrito");
        $carritoNoExiste->assertJson([
            "respuesta"=>false,
            "error"=>"El carrito no está iniciado, debe iniciar sesión."
        ]);

        //Si tiene sesion pero el carrito está vacío
        $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $carritoExisteVacio = $this->get("/cargarCarrito");

        $carritoExisteVacio->assertJson([]);
    }

    public function test_añadirLibros() {
        //No debe permitir añadir libros si no tiene una sesión iniciada
        $añadirSinSesion = $this->post("/agregarLibros", ["isbn"=>1, "unidades"=>2]);
        $añadirSinSesion->assertJson(["respuesta"=>false, "error"=>"Debe iniciar sesion antes de añadir libros"]);

        //Se debe poder añadir libros si la sesión está iniciada
        $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $this->post("/agregarLibros", ["isbn"=>1, "unidades"=>2]);
        $cargarConSesion = $this->get("/cargarCarrito");

        $this->assertTrue(Session::has("Carrito"));
        $this->assertEquals(Session::get("Carrito"), [["isbn"=>1, "unidades"=>2]]);
        $cargarConSesion->assertJson([
            ["numunidades"=>2,"numarticulos"=>1],
            [
                "isbn"=>"1",
                "unidades"=>2,
                "titulo"=>"Guía del Autoestopista Galático",
                "escritores"=>"Douglas Adams",
                "genero"=>"Comedia",
                "numpaginas"=>"257 pág.",
                "imagen"=>"img/autoestopista.jpg"
            ]]);
    }

    public function test_eliminarLibros() {
        //No debe poder eliminar libros sin tener una sesión
        $eliminarSinSesion = $this->post("/eliminarLibros", ["isbn"=>1, "unidades"=>2]);
        $eliminarSinSesion->assertJson(["respuesta"=>false, "error"=>"Debe iniciar sesion antes de añadir libros."]);

        //No debe poder borrar libros con el carrito vacío
        $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $eliminarVacio = $this->post("/eliminarLibros", ["isbn"=>2, "unidades"=> 15]);

        $eliminarVacio->assertJson(["respuesta"=>false, "error"=>"El carrito está vacío."]);

        //Se añade los libros y debería poder borrarlo
        $this->post("/agregarLibros", ["isbn"=>1, "unidades"=>2]);
        $eliminarCorrecto = $this->post("/eliminarLibros", ["isbn"=>1, "unidades"=>1]);
        $cargarCarrito = $this->get("/cargarCarrito");

        $eliminarCorrecto->assertJson(["respuesta"=>true, "error"=>""]);
        $cargarCarrito->assertJson([
            ["numunidades"=>1,"numarticulos"=>1],
            [
                "isbn"=>"1",
                "unidades"=>1,
                "titulo"=>"Guía del Autoestopista Galático",
                "escritores"=>"Douglas Adams",
                "genero"=>"Comedia",
                "numpaginas"=>"257 pág.",
                "imagen"=>"img/autoestopista.jpg"
            ]]);

    }
}
