<?php
require_once 'modulo.php';

class FranjaHorario
{
    private $modulo;        
    private $dia;
    private $hora;
    private $tipoFranja;
    private $color;

        public function __construct($modulo, $dia, $hora, $tipo, $color) {
            $this->modulo = $modulo;
            $this->dia = $dia; 
            $this->hora = $hora;
            $this->tipoFranja = $tipo;
            $this->color = $color;

    }

    public function getModulo() {
        return $this->modulo;
    }
    public function getHora() {
        return $this->hora;
    }
    public function getTipoFranja() {
        return $this->tipoFranja;
    }
    public function getColor() {
        return $this->color;
    }
    public function setColor($color) {
        $this->color = $color;

    }
    public function getDia() {
        return $this->dia;
    }

}
