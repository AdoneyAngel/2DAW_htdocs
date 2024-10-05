<?php

abstract class Pieza {
    protected $color;
    protected $fullName = "pieza";
    protected $pasos;

    public function __construct($color) {
        $this->color = $color;
        $this->pasos = 0;
    }

    public function siguientePaso() {
        $this->pasos++;
        return $this->pasos;
    }

    abstract public function validateMove($prevPos, $newPos, $tablero);
    abstract public function getName();

    public function setFullName($nombre) {
        $this->fullName = $nombre."_".$this->color;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getColor() {
        return $this->color;
    }

    protected function diferencia($n1, $n2) {

        if ($n1 > $n2) {
            return $n1-$n2;

        } else {
            return $n2-$n1;
        }

    }
}

?>