<?php

// agenda string => nombre, telefono|nomobre, telefono...

require_once("./model/Agenda.php");
require_once("./model/Contacto.php");

class Controller {

    private $isInsert = false;
    private $isEdit = false;
    private $isDelete = false;
    private $agenda;

    public function __construct()
    {
        $this->loadMethod();
        $this->loadAgenda();

        if ($this->isInsert) {
            $this->addContact();

        } else if ($this->isEdit) {
            $this->editContact();

        } else if($this->isDelete) {
            $this->deleteContact();

        }
    }

    private function deleteContact() {
        if (isset($_POST["nombre"]) && !empty($_POST["nombre"])) {
            $contacto = $this->buscarContacto($_POST["nombre"]);

            if ($contacto) {
                $this->agenda->deleteContact($contacto);

                return true;

            }

            return false;
        }
    }

    private function editContact() {
        if (isset($_POST["nombre"]) && isset($_POST["telefono"]) && !empty($_POST["nombre"]) && !empty($_POST["telefono"])) {
            $contacto = $this->buscarContacto($_POST["nombre"]);

            $editado = false;

            if ($contacto) {
               $editado = $this->agenda->editContact($contacto, $_POST["telefono"]); 
            }

            return $editado;

        } else {
            return false;
        }
    }

    private function buscarContacto($nombre) {
        return $this->agenda->search($nombre);
    }

    private function addContact() {
        if (isset($_POST["nombre"]) && isset($_POST["telefono"]) && !empty($_POST["nombre"]) && !empty($_POST["telefono"])) {
            $nombre = $_POST["nombre"];
            $telefono = $_POST["telefono"];

            $nuevoContacto = new Contacto($nombre, $telefono);

            $this->agenda->add($nuevoContacto);
        }
    }

    private function loadMethod() {
        if (isset($_POST["insertar"])) {
            $this->isInsert = true;
        }
        if (isset($_POST["borrar"])) {
            $this->isDelete = true;
        }
        if (isset($_POST["editar"])) {
            $this->isEdit = true;
        }
    }

    public function getAgendaString() {
        return $this->agenda->getAgendaString();
    }

    public function getAgenda() {
        return $this->agenda;
    }

    private function loadAgenda() {
        if (isset($_POST["agendaString"])) {
            $contactos = array();

            if (empty($_POST["agendaString"])) {
                $this->agenda = new Agenda(array());

            } else {
                $agendaArray = explode("|", $_POST["agendaString"]);

                // Se recorre cada usuario
                foreach ($agendaArray as $usuarioAgenda) {
                    $nombre = explode(",", $usuarioAgenda)[0];
                    $telefono = explode(",", $usuarioAgenda)[1];

                    $contactos[] = new Contacto($nombre, $telefono);
                }

                $this->agenda = new Agenda($contactos);                
            }
            
        } else {
            $this->agenda = new Agenda(array());
        }
    }


}

?>