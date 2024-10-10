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

}
