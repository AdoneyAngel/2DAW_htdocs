<?php
class Modulo{
    private $curso;
    private $materia;
    private $clase;

    public function __construct($curso, $materia, $clase) {
        $this->curso = $curso;
        $this->materia = $materia;
        $this->clase = $clase;

    }
}