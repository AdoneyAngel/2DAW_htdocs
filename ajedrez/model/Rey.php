<?php

include_once("./model/Pieza.php");

class Rey extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("rey");
    }

    public function getName() {
        return "rey";
    }


    public function validateMove($prevPos, $newPos, $tablero)
    {
        $inFila = $prevPos[0];
        $inCol = $prevPos[1];
        $finFila = $newPos[0];
        $finCol = $newPos[1];

        //Comprobar que estén dentro del rango
        if ($finFila > 7 || $finFila < 0 || $finCol > 7 || $finCol < 0) {
            return false;
        }

        //comprobar que de solo 1 paso
        //Comprobar si va recto
        $pieza = $tablero->getPieza($finFila, $finCol);

        if (($finFila == $inFila+1 || $finFila == $inFila-1) && $finCol == $inCol || ($finCol == $inCol+1 || $finCol == $inCol-1) && $finFila == $inFila) {
            //Comprobar si hay una pieza y si es rival
            if ($pieza) {
                if ($pieza->getColor() !== $this->color) {
                    return true;

                } else {
                    return false;
                }
                 
            } else {
                return true;
            }
        }

        //Comprobar si va en diagonal
        if ($this->diferencia($inFila, $finFila) == 1 && $this->diferencia($inCol, $finCol) == 1) {
            //Comprobar si hay una pieza y si es rival
            if ($pieza) {
                if ($pieza->getColor() !== $this->color) {
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