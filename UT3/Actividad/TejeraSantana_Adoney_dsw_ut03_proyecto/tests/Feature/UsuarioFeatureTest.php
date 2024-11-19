<?php

namespace Tests\Feature;

use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UsuarioFeatureTest extends TestCase
{

    /**
     * Comprobar que inicia sesion (comprobando si es válido los datos) y crea el fichero (si no existe)
     */

    public function test_isLogged() {
        //Comprobar cuando no hay sesion
        $noLogueado = $this->get("/isLogged");
        $noLogueado->assertJson(["respuesta"=>false, "error"=>""]);

        //Comprobar cuando SI hay sesion
        $abrirSesion = $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $logueado = $this->get("/isLogged");

        $logueado->assertJson(["respuesta"=>true, "error"=>""]);

    }

    public function test_login() {
        $rutaFicheroAccesos = Storage::disk("datos")->path("info_accesos.dat");

        //Comprobar que no puede iniciar sesion si no se le envía los datos necesarios
        $respuestaSinDatos = $this->post("/login", []);
        $respuestaSinDatos->assertJson(["respuesta"=>false, "error"=>"Faltan parámetros"]);

        //No debe iniciar sesion, usuario no válido
        $respuestaEsperadaFalso = $this->post("/login", ["usuario"=>"prueba", "clave"=>"1223"]);
        $respuestaEsperadaFalso->assertJson(["respuesta"=>false,"error"=>""]);

        //Debe iniciar sesión, además de crear el fichero de inicio de sesion y las sesiones
        $respuestaEsperadaTrue = $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $respuestaEsperadaTrue->assertJson(["respuesta"=>true, "error"=>""]);

        //---Debe crear las variables de sesiones
        $this->assertEquals("root@email.com", Session::get("Usuario"));
        $this->assertEquals([], Session::get("Carrito"));
        $this->assertTrue(Session::has("IdSesion"));

        //---Debe crear el fichero de datos
        $this->assertFileExists($rutaFicheroAccesos);
    }

    public function test_logout() {
        //Comprobar que sin una sesión iniciada no puede cerrarla
        $cierreSesionInválido = $this->get("/logout");
        $cierreSesionInválido->assertJson(["respuesta"=>false, "error"=>"Sesion no iniciada"]);

        $this->assertFalse(Session::has("Usuario"));
        $this->assertFalse(Session::has("Carrito"));
        $this->assertFalse(Session::has("IdSesion"));

        //Comprobar que cierra sesión con una sesión abierta
        $abrirSesion = $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $cierreSesionVálido = $this->get("/logout");

        $abrirSesion->assertJson(["respuesta"=>true, "error"=>""]);
        $cierreSesionVálido->assertJson(["respuesta"=>true, "error"=>""]);
    }

    public function test_cargarUsuario() {
        //No puede cargar un usuario si no hay sesion
        $sinUsuario = $this->get("/cargarUsuario");
        $sinUsuario->assertJson(["respuesta"=>false, "error"=>"No tiene una sesión iniciada"]);

        //Debe cargar un usuario si HAY una sesion
        $abrirSesion = $this->post("/login", ["usuario"=>"root@email.com", "clave"=>"1234"]);
        $conUsuario = $this->get("/cargarUsuario");

        $conUsuario->assertSee("root@email.com");
    }

    public function test_obtenerAccesos() {

    }

}
