<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class User
{
    private $name;
    private $lastName;
    private $pass;
    private $rutaXml;
    private $users = array();
    private $userDataValidator;

    public function __construct($name, $pass) {
        $this->name = $name;
        $this->pass = $pass;

        $this->rutaXml = Storage::disk("usersData")->path("/users.xml");
        $this->userDataValidator = Storage::disk("usersData")->path("/usersXsd.xsd");
    }

    public function getName():string {
        return $this->name;
    }
    public function getPassword():string {
        return $this->pass;
    }

    public function getInfo() {
        $this->loadData();
        $xmlDom = new \DOMDocument();
        $xmlDom->load($this->rutaXml);

        try {
            if ($xmlDom->schemaValidate($this->userDataValidator)) {
                $contenidoXml = simplexml_load_file($this->rutaXml);
                $usuarios = $contenidoXml->xpath("//user");

                foreach ($usuarios as $usuario) {
                    if ($usuario->name == $this->name) {
                        $info = [
                            "name" => $usuario->name,
                            "lastName" => $usuario->lastName,
                            "password" => $usuario->password
                        ];

                        return $info;
                    }
                }

                return false;

            } else {
                throw new \Exception("Estructura de datos inválido");
            }

        } catch (\Exception $e) {
            return response("Error al validar la estructura de los datos: " . $e->getMessage());
        }
    }

    public function login() {
        $this->loadData();//Se carga los usuarios del fichero de datos

        //Comprobar parámetros
        $user = $this->getUser($this->name);

        if ($user && $user->getPassword() === $this->pass) {
            return true;

        } else {
            return false;
        }

    }

    private function getUser($name) {
        $this->loadData();

        foreach ($this->users as $user) {
            if ($user->getName() === $name) {
                return $user;
            }
        }

        return null;
    }

    private function loadData() {
        $xmlDom = new \DOMDocument();
        $xmlDom->load($this->rutaXml);

        try {
            if ($xmlDom->schemaValidate($this->userDataValidator)) {
                $contenidoXml = simplexml_load_file($this->rutaXml);
                $usuarios = $contenidoXml->xpath("//user");

                foreach ($usuarios as $usuario) {
                    $usuarioActual = new User($usuario->name, $usuario->password);

                    $this->users[] = $usuarioActual;
                }

                return true;

            } else {
                throw new \Exception("Estructura de datos inválido");
            }

        } catch (\Exception $e) {
            return response("Error al validar la estructura de los datos: " . $e->getMessage());
        }

    }
}
