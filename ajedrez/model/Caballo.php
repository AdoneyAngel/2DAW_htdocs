<?php

include_once("./model/Pieza.php");

class Caballo extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("caballo");
    }

    public function getName() {
        return "caballo";
    }


    public function validateMove($prevPos, $newPos, $tablero)
    {
        $inFila = $prevPos[0];
        $inCol = $prevPos[1];
        $finFila = $newPos[0];
        $finCol = $newPos[1];

        //Comprobar que las coordenadas esten dentro del rango
        if ($finFila <= 7 && $finFila >= 0 && $finCol <= 7 && $finCol >= 0) {
            $pieza = $tablero->getPieza($finFila, $finCol);

            //Comprobar si da 2 pasos verticales
            if ($finFila == $inFila+2 || $finFila == $inFila-2) {
                //Comprobar si da 1 paso a un lado
                if ($finCol == $inCol+1 || $finCol == $inCol-1) {
                    if ($pieza) {
                        //Comprobar si la pieza es rival
                        if ($pieza->getColor() !== $this->color) {
                            return true;

                        } else {
                            return false;
                        }

                    } else {
                        return true;
                    }
                }

            } else if ($finCol == $inCol+2 || $finCol == $inCol-2) {
                //Comprobar si da 1 paso a un lado
                if ($finFila == $inFila+1 || $finFila == $inFila-1) {
                    if ($pieza) {
                        //Comprobar si la pieza es rival
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

        } else {
            return false;
        }

    }
}

?>