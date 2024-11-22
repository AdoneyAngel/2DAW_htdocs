<?php

namespace Tests\Unit;

use App\Models\Genero;
use Tests\TestCase;

class GeneroUnitTest extends TestCase
{

    public function test_getGeneros() {
        $generos = Genero::getGeneros();

        $this->assertEquals(["cod"=>0,"nombre"=>"Comedia"], $generos[0]);
        $this->assertEquals(["cod"=>1,"nombre"=>"Ciencia Ficción"], $generos[1]);
    }

    public function test_existeGenero() {
        $existeGenero = Genero::existeGenero("Terror");
        $noExisteGenero = Genero::existeGenero("Futuristico");

        $this->assertTrue($existeGenero);
        $this->assertFalse($noExisteGenero);
    }

    public function test_getLibrosGenero() {
        $libros = Genero::getLibrosGenero("Distopía");

        $this->assertEquals([
            [
                "isbn"=>"4",
                "titulo"=>"El señor de las moscas",
                "escritores"=>"William Golding",
                "genero"=>"Distopía",
                "numpaginas"=>"290 pág.",
                "imagen"=>"img/moscas.jpg"
            ]
            ], $libros);

        //Comprobar excepciones
        $this->expectException(\Exception::class);
        Genero::getLibrosGenero("Romantico");//No existe el genero
        Genero::getLibrosGenero("");//Parámetro vacío


    }

}
