<?php

namespace Tests\Feature;

use Tests\TestCase;
use function PHPUnit\Framework\assertJson;

class LibroFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_cargarLibros() {//Cargar libro sin sesion iniciada ni carrito
        $librosRes = $this->get("/cargarLibros");
        $librosRes->assertJsonFragment([
            [
                "isbn"=>"1",
                "titulo"=>"Guía del Autoestopista Galático",
                "escritores"=>"Douglas Adams",
                "genero"=>"Comedia",
                "numpaginas"=>"257 pág.",
                "imagen"=>"img/autoestopista.jpg",
                "unidades"=>0
            ]
        ]);
    }
}
