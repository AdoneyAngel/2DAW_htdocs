<?php

namespace Tests\Unit;

use App\Models\Libro;
use Tests\TestCase;

class LibroUnitTest extends TestCase
{
    public function test_getLibros() {
        $model = new Libro();

        $libros = $model->getLibros();

        $this->assertEquals([
            "isbn"=>"1",
            "titulo"=>"Guía del Autoestopista Galático",
            "escritores"=>"Douglas Adams",
            "genero"=>"Comedia",
            "numpaginas"=>"257 pág.",
            "imagen"=>"img/autoestopista.jpg"
        ], $libros[0]);
    }

    public function test_existeLibro() {
        $isbn = 4;

        $existe = Libro::existeLibro($isbn);
        $this->assertTrue($existe);

        $noExiste = Libro::existeLibro(55);
        $this->assertFalse($noExiste);
    }

    public function test_getLibroDatos() {
        $isbn = 2;

        $libro = Libro::getLibroDatos($isbn);
        $this->assertEquals([
            "isbn"=>"2",
            "titulo"=>"Trilogía de la Fundación",
            "escritores"=>"Isaac Asimov",
            "genero"=>"Ciencia Ficción",
            "numpaginas"=>"895 pág.",
            "imagen"=>"img/fundacion.jpg"
        ], $libro);

        //Deberia dar una excepción si no existe
        $this->expectException(\Exception::class);
        $libroNoExiste = Libro::getLibroDatos(44);
    }

}
