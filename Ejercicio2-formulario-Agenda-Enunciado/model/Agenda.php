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

            }
        }

        return false;
    }

    public function getAgendaString() {
        $agendaString = "";

        foreach ($this->contactos as $contacto) {
            $agendaString = "$agendaString|".$contacto->getNombre().",".$contacto->getTelefono();
        }

        $agendaString = substr($agendaString, 1);

        return $agendaString;
    }

    public function getContactos() {
        return $this->contactos;    
    }

    public function editContact($contacto, $telefono) {
        if ($this->exist($contacto)) {
            $contacto->edit($telefono);
            
            return true;

        } else {
            return false;
        }
    }

    public function deleteContact($contacto) {
        foreach ($this->contactos as $index => $contactoActual) {
            if ($contactoActual->getNombre() === $contacto->getNombre()) {
                unset($this->contactos[$index]);
            }
        }
    }

    public function search($nombre) {
        foreach ($this->contactos as $contacto) {
            if ($contacto->getNombre() === $nombre) {
                return $contacto;
            }
        }

        return false;
    }
}

?>