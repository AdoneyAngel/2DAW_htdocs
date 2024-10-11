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
    public function getCurso() {
        return $this->curso;
    }
    public function getMateria() {
        return $this->materia;
    }
    public function setMateria($materia) {
        $this->materia = $materia;
    }
    public function getClase() {
        return $this->clase;
    }
}