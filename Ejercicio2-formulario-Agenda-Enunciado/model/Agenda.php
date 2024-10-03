<?php

require_once("./model/Contacto.php");

class Agenda {

    private $contactos;

    public function __construct($contactos)
    {
        $this->contactos = $contactos; 
    }

    public function add($contacto) {
        if (!$this->exist($contacto)) {
            $this->contactos[] = $contacto;

            return true;

        } else {
            return false;
        }
    } 

    public function exist($contacto) {
        foreach ($this->contactos as $contactoActual) {
            if ($contactoActual->getNombre() === $contacto->getNombre()) {
                return true;

            } else {
                return false;
            }
        }
    }

    public function getAgendaString() {
        $agendaString = "";

        foreach ($this->contactos as $contacto) {
            $agendaString = "$agendaString|".$contacto->getNombre().",".$contacto->getTelefono();
        }

        $agendaString = substr($agendaString, 1);

        return $agendaString;
    }
}

?>