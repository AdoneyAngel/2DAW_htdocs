<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeneroFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */

     //[{"cod":0,"nombre":"Comedia"},{"cod":1,"nombre":"Ciencia Ficci\u00f3n"},{"cod":2,"nombre":"Hist\u00f3rica"},{"cod":3,"nombre":"Distop\u00eda"},{"cod":4,"nombre":"Terror"}]
    public function test_cargarGeneros() {
        //Debe de haber exactamente los géneros que hay en los libros
        $generos = $this->get("/cargarGeneros");
        $generos->assertJson([
            [
                "cod"=>0,
                "nombre"=>"Comedia"
            ],
            [
                "cod"=>1,
                "nombre"=>"Ciencia Ficción"
            ],
            [
                "cod"=>2,
                "nombre"=>"Histórica"
            ],
            [
                "cod"=>3,
                "nombre"=>"Distopía"
            ],
            [
                "cod"=>4,
                "nombre"=>"Terror"
            ]
        ]);
    }

    public function test_cargarGeneroLibros() {
        //No debe permitir géneros que no existen
        $librosGeneroNoExiste = $this->get("/cargarGeneroLibros/generoNoExistente");
        $librosGeneroNoExiste->assertJson(["respuesta"=>false,"error"=>"El género no existe."]);

        //Debe mostrar los libros del genero indicado
        $librosGeneroExiste = $this->get("/cargarGeneroLibros/Comedia");
        $librosGeneroExiste->assertJson([
            [
                "isbn"=>"1",
                "titulo"=>"Guía del Autoestopista Galático",
                "escritores"=>"Douglas Adams",
                "genero"=>"Comedia",
                "numpaginas"=>"257 pág.",
            ]
        ]);
    }
}
