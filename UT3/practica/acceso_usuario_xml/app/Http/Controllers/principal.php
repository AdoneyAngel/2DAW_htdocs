<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use URL;

class principal extends Controller
{
    private $users = array();
    private $rutaUsuarios;
    private $rutaValidador;

    public function __construct() {
        $this->rutaUsuarios = Storage::disk("usersData")->path("users.xml");
        $this->rutaValidador = Storage::disk("usersData")->path("usersXsd.xsd");
    }

    public function index() {
        if ($this->validarSesion()) {
            $this->loadUsers();

            $nombres = $this->filtroNombre();

            return view("principal", ["usuarios" => $nombres]);

        } else {
            return redirect()->route("login");
        }

    }

    public function showInfo(Request $request) {
        if ($request->has("user") && !empty($request->get("user"))) {
            $name = $request->get("user");
            $usuarioModel = new User($name, "fafdafd");

            $userInfo = $usuarioModel->getInfo();

            return view("info", ["name"=> $userInfo["name"], "lastName" => $userInfo["lastName"], "password" => $userInfo["password"]]);

        } else {
            return $this->index();
        }
    }

    private function validarSesion() {
        if (Session::has("name") && !empty(Session::get("name")) && Session::has("login") && Session::get("login")) {
            return true;

        } else {
            return false;
        }
    }

    private function filtroNombre() {
        $nombres = array();

        foreach ($this->users as $usuario) {
            $nombres[] = $usuario["name"];
        }

        return $nombres;
    }

    private function loadUsers() {
        $xmlDom = new \DOMDocument();
        $xmlDom->loadXML(file_get_contents($this->rutaUsuarios));

        if ($xmlDom->schemaValidate($this->rutaValidador)) {
            $contenidoXml = simplexml_load_file($this->rutaUsuarios);
            $usuarios = $contenidoXml->xpath("//user");

            foreach ($usuarios as $usuario) {
                $usuarioActual = [
                    "name" => $usuario->name,
                    "lastName" => $usuario->lastName
                ];

                $this->users[] = $usuarioActual;
            }

            return true;

        } else {
            return false;
        }
    }
}
