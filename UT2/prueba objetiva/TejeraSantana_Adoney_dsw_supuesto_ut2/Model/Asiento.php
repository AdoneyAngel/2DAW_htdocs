<?php

class Asiento {
    private $tipo;
    private $fila;
    private $columna;
    
    public function __construct($tipo, $fila, $columna) {
        $this->tipo = $tipo;
        $this->fila = $fila;
        $this->columna = $columna;
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function getFila() {
        return $this->fila;
    }
    public function getColumna() {
        return $this->columna;
    }

}