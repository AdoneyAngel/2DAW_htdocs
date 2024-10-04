<?php

abstract class Pieza {
    protected $color;
    protected $fullName = "pieza";

    public function __construct($color) {
        $this->color = $color;
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
}

?>