<?php

class Contacto {

    private $nombre;
    private $telefono;

    public function __construct($nombre, $telefono)
    {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    
}

?>