<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UsuarioUnitTest extends TestCase
{

    public function test_getUsuarios() {
        $model = new Usuario();

        $getUsuarios = $model->getUsuarios();

        $this->assertEquals([[
            "usuario"=>"root@email.com",
            "clave"=>"1234"
        ]], $getUsuarios);
    }

    public function test_guardarInicioSesion() {
        $fechaActual = date("Y:m:d H:i:s");
        Storage::disk("datos")->delete("info_accesos.dat");

        //Comprobar que si no hay sesion activa pues no puede guardar nada
        $this->expectException(\Exception::class);
        Usuario::guardarInicioSesion();

        Session::put("Usuario", "test");//Se guarda el usuario para la sesion
        $idSesion = Usuario::guardarInicioSesion();//Se guarda el inicio de sesion

        $this->assertFileExists(Storage::disk("datos")->path("info_accesos.dat"));//Se comprueba que crea el fichero

        $contenidoAccesosFichero = Storage::disk("datos")->get("info_accesos.dat");
        $this->assertStringContainsString($contenidoAccesosFichero, "$idSesion#test#$fechaActual#\n");
    }

    public function test_guardarFinSesion() {
        $this->test_guardarInicioSesion();//Se llama al metodo anterior para que borre y genere un acceso

        $fechaActual = date("Y:m:d H:i:s");

        //Comprobar que si no hay sesion activa pues no puede guardar nada
        $this->expectException(\Exception::class);
        Usuario::guardarFinSesion();

        //Se guarda las variables de sesion para que permita guardarCierre
        Session::put("Usuario", "test");
        Session::put("IdSesion", "0");

        Usuario::guardarFinSesion();

        $contenidoAccesosFichero = Storage::disk("datos")->get("info_accesos.dat");
        $this->assertStringContainsString($contenidoAccesosFichero, "0#test#$fechaActual#$fechaActual\n");
    }

    public function test_generarCodigo() {
        Storage::disk("datos")->delete("info_accesos.dat");

        Session::put("Usuario", "testGenerarCodigo");
        $idSesion1 = Usuario::guardarInicioSesion();
        $idSesion2 = Usuario::guardarInicioSesion();

        $this->assertEquals(0, $idSesion1);
        $this->assertEquals(1, $idSesion2);
    }

}
