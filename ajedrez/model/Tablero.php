<?php

//tablero[fila][columna] = pieza

include_once("./model/Peon.php");
include_once("./model/Alfil.php");
include_once("./model/Caballo.php");
include_once("./model/Reina.php");
include_once("./model/Rey.php");
include_once("./model/Torre.php");

class Tablero {
    private $piezas;

    public function __construct() {
        
    }

    public function inicializar() {
        $nuevoTablero = array();

        //Primera fila negra
        $nuevoTablero[0][0] = new Torre("negro");
        $nuevoTablero[0][1] = new Caballo("negro");
        $nuevoTablero[0][2] = new Alfil("negro");
        $nuevoTablero[0][3] = new Reina("negro");
        $nuevoTablero[0][4] = new Rey("negro");
        $nuevoTablero[0][5] = new Alfil("negro");
        $nuevoTablero[0][6] = new Caballo("negro");
        $nuevoTablero[0][7] = new Torre("negro");
        //Peones fila negra
        $nuevoTablero[1][0] = new Peon("negro");
        $nuevoTablero[1][1] = new Peon("negro");
        $nuevoTablero[1][2] = new Peon("negro");
        $nuevoTablero[1][3] = new Peon("negro");
        $nuevoTablero[1][4] = new Peon("negro");
        $nuevoTablero[1][5] = new Peon("negro");
        $nuevoTablero[1][6] = new Peon("negro");
        $nuevoTablero[1][7] = new Peon("negro");

        //Espacio vacío
        for($fila = 2; $fila <= 5; $fila++) {
            for ($columna = 0; $columna<=7; $columna++) {
                $nuevoTablero[$fila][$columna] = null;
            }
        }

        //Peones fila blanca
        $nuevoTablero[6][0] = new Peon("blanco");
        $nuevoTablero[6][0] = new Peon("blanco");
        $nuevoTablero[6][0] = new Peon("blanco");
        $nuevoTablero[6][1] = new Peon("blanco");
        $nuevoTablero[6][2] = new Peon("blanco");
        $nuevoTablero[6][3] = new Peon("blanco");
        $nuevoTablero[6][4] = new Peon("blanco");
        $nuevoTablero[6][5] = new Peon("blanco");
        $nuevoTablero[6][6] = new Peon("blanco");
        $nuevoTablero[6][7] = new Peon("blanco");
        //Primera fila blanca
        $nuevoTablero[7][0] = new Torre("blanco");
        $nuevoTablero[7][1] = new Caballo("blanco");
        $nuevoTablero[7][2] = new Alfil("blanco");
        $nuevoTablero[7][3] = new Reina("blanco");
        $nuevoTablero[7][4] = new Rey("blanco");
        $nuevoTablero[7][5] = new Alfil("blanco");
        $nuevoTablero[7][6] = new Caballo("blanco");
        $nuevoTablero[7][7] = new Torre("blanco");

        $this->piezas = $nuevoTablero;

    }

    public function seldaVacia($fila, $columna) {
        if ($this->piezas[$fila][$columna]) {
            return false;
            
        }

        return true;
    }

    public function getPieza($fila, $columna) {
        return $this->piezas[$fila][$columna];
    }

    public function sustituir($fila, $columna, $nuevaFila, $nuevaColumna) {
        $pieza = $this->getPieza($fila, $columna);
        $piezaOcupar = $this->getPieza($nuevaFila, $nuevaColumna);

        $this->piezas[$nuevaFila][$nuevaColumna] = $pieza;
        $this->piezas[$fila][$columna] = $piezaOcupar;

        return $this->piezas;
    }

    public function mover($fila, $columna, $nuevaFila, $nuevaColumna) {
        $pieza = $this->getPieza($fila, $columna);

        $this->piezas[$nuevaFila][$nuevaColumna] = $pieza;
        $this->piezas[$fila][$columna] = null;

        return $this->piezas;
    }
}

?>