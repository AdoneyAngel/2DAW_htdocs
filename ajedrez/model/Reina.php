<?php

include_once("./model/Pieza.php");

class Reina extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("reina");
    }

    public function getName() {
        return "reina";
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

        //Comprobar si va recto
        if ($inFila === $finFila && $inCol != $finCol || $inFila != $finFila && $inCol == $finCol) {
            //Comprobar si hay alguna pieza en su direccion

            if($inFila < $finFila) {//Comprobar si va hacia abajo y si hay una pieza en medio
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }

            } else if ($inFila > $finFila) {//Comprobar si va hacia arriba y si hay una pieza en medio
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
                
            } else if ($inCol < $finCol) {//Comprobar si va hacia la derecha y si hay una pieza en medio
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
                
            } else if ($inCol > $finCol) {//Comprobar si va hacia la inzquierda y si hay una pieza en medio
                if ($tablero->piezaEnMedio($inFila, $inCol, $finFila, $finCol)) {
                    return false;
                }
            }

            //Comprobar si cae sobre una pieza
            if ($pieza) {
                if ($pieza->getColor() != $this->color) {//Comprobar si es rival
                    return true;

                } else {
                    return false;
                }

            } else {
                return true;
            }
        }

        //Comprobar si es una diagonal
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

        return false;
    }
}

?>