<?php

include_once("./model/Pieza.php");

class Alfil extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("alfil");
    }

    public function getName() {
        return "alfil";
    }

    public function validateMove($prevPos, $newPos, $tablero)
    {
        $inFila = $prevPos[0];
        $inCol = $prevPos[1];
        $finFila = $newPos[0];
        $finCol = $newPos[1];
        
        //Dentro del rango
        if ($finFila > 7 || $finFila < 0 || $finCol > 7 || $finCol < 0) {
            return false;
        }

        $pieza = $tablero->getPieza($finFila, $finCol);

        if ($this->diferencia($inFila, $finFila) === $this->diferencia($inCol, $finCol)) {
            
            if ($inFila < $finFila && $inCol < $finCol) {//Abajo-derecha
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }

            } else if ($inFila > $finFila && $inCol < $finCol) {//Arriba-derecha
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
                
            } else if ($inFila > $finFila && $inCol > $finCol) {//Arriba-inzquierda
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
                
            } else if ($inFila < $finFila && $inCol > $finCol) {//Abajo-izquierda
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
                
            }

            if ($pieza) {//Comprobar si cae en una pieza rival
                if ($pieza->getColor() != $this->color) {
                    return true;

                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}

?>