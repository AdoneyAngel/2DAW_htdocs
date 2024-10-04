<?php

include_once("./model/Pieza.php");

class Peon extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("peon");
    }

    public function getName() {
        return "peon";
    }


    public function validateMove($prevPos, $newPos, $tablero)
    {
        $nuevaFila = $newPos[0];
        $nuevaCol = $newPos[1];
        $fila = $prevPos[0];
        $col = $prevPos[1];

        //pieza negra
        if ($this->color === "negro") {
            //Comprobar si quiere ir al frente (solo puede dar 1 paso)

            if ($nuevaFila == $fila+1 && $col == $nuevaCol) {
                //Comprobar si hay algo al frente
                if ($tablero->seldaVacia($nuevaFila, $nuevaCol)) {
                    return true;

                } else {
                    return false;
                }

            } else if ($nuevaFila == $fila+1 && ($nuevaCol == $col+1 || $nuevaCol == $col-1)) {
                //Validar si hay alguna pieza en esa posicion
                if (!$tablero->seldaVacia($nuevaFila, $nuevaCol)) {
                    //Debe ser rival
                    $piezaDeSelda = $tablero->getPieza($nuevaFila, $nuevaCol);
                    
                    if ($piezaDeSelda->getColor() === "blanco") {
                        return true;    
                    }

                    return false;

                } else {
                    return false;
                }
            }
        }

        //pieza blanca
        if ($this->color === "blanco") {
            //Comprobar si quiere ir al frente (solo puede dar 1 paso)

            if ($nuevaFila == $fila-1 && $col == $nuevaCol) {
                //Comprobar si hay algo al frente
                if ($tablero->seldaVacia($nuevaFila, $nuevaCol)) {
                    //Debe ser rival
                    $piezaDeSelda = $tablero->getPieza($nuevaFila, $nuevaCol);
                    
                    if ($piezaDeSelda->getColor() === "negro") {
                        return true;    
                    }

                    return false;

                } else {
                    return false;
                }

            } else if ($nuevaFila == $fila-1 && ($nuevaCol == $col+1 || $nuevaCol == $col-1)) {
                //Validar si hay alguna pieza en esa posicion
                if (!$tablero->seldaVacia($nuevaFila, $nuevaCol)) {
                    return true;

                } else {
                    return false;
                }
            }
        }
    }
}

?>