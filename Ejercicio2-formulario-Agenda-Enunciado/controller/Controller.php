<?php

// agenda string => nombre, telefono|nomobre, telefono...

// HACER VISIBLE LA LISTA DE CONTACTOS

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
        }
    }

    private function addContact() {
        if (isset($_POST["nombre"]) && isset($_POST["telefono"])) {
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
            
        }
    }


}

?>