<?php

include_once("./model/Pieza.php");

class Torre extends Pieza {

    public function __construct($color) {
        parent::__construct($color);

        $this->setFullName("torre");
    }

    public function getName() {
        return "torre";
    }


    public function validateMove($prevPos, $newPos, $tablero)
    {
        $inFila = $prevPos[0];
        $inCol = $prevPos[1];
        $finFila = $newPos[0];
        $finCol = $newPos[1];

        //Comprobar que el movimiento es recto 
        if (($inFila != $finFila && $inCol == $finCol) || ($inFila == $finFila && $inCol != $finCol)) {
            //Comprobar si está subiendo/bajando
            if ($finFila>$inFila) {
                //Comprobar que esté dentro del rango
                if ($finFila <= 7 && $finFila >= 0) {
                    $piezaEnMedio = false;
                    //Comprobar si hay alguna pieza en medio
                    for ($filaIndex = $inFila+1; $filaIndex<$finFila; $filaIndex++) {
                        if (!$tablero->seldaVacia($filaIndex, $inCol)) {
                            $piezaEnMedio = true;
                        }
                    }

                    if (!$piezaEnMedio) {
                        //Si no hay, comprobar si cae sobre una pieza rival
                        if ($tablero->seldaVacia($finFila, $inCol)) {
                            return true;

                        } else {
                            $pieza = $tablero->getPieza($finFila, $inCol);

                            if ($pieza->getColor() !== $this->color) {
                                return true;

                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                }
            } else if ($finFila<$inFila) {
                //Comprobar que esté dentro del rango
                if ($finFila <= 7 && $finFila >= 0) {
                    $piezaEnMedio = false;
                    //Comprobar si hay alguna pieza en medio
                    for ($filaIndex = $inFila-1; $filaIndex>$finFila; $filaIndex--) {
                        if (!$tablero->seldaVacia($filaIndex, $inCol)) {
                            $piezaEnMedio = true;
                        }
                    }

                    if (!$piezaEnMedio) {
                        //Si no hay, comprobar si cae sobre una pieza rival
                        if ($tablero->seldaVacia($finFila, $inCol)) {
                            return true;

                        } else {
                            $pieza = $tablero->getPieza($finFila, $inCol);

                            if ($pieza->getColor() !== $this->color) {
                                return true;

                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                }
            }

            //Comprobar si va a la derecha/izquierda
            if ($finCol>$inCol) {//Derecha
                //Comprobar que esté dentro del rango
                if ($finCol <= 7 && $finCol >= 0) {
                    $piezaEnMedio = false;
                    //Comprobar si hay alguna pieza en medio
                    for ($colIndex = $inCol+1; $colIndex<$finCol; $colIndex++) {
                        if (!$tablero->seldaVacia($inFila, $colIndex)) {
                            $piezaEnMedio = true;
                        }
                    }

                    if (!$piezaEnMedio) {
                        //Si no hay, comprobar si cae sobre una pieza rival
                        if ($tablero->seldaVacia($finFila, $finCol)) {
                            return true;

                        } else {
                            $pieza = $tablero->getPieza($finFila, $finCol);

                            if ($pieza->getColor() !== $this->color) {
                                return true;

                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                }

            } else if ($finCol<$inCol) {//izquierda
                //Comprobar que esté dentro del rango
                if ($finCol <= 7 && $finCol >= 0) {
                    $piezaEnMedio = false;
                    //Comprobar si hay alguna pieza en medio
                    for ($colIndex = $inCol-1; $colIndex>$finCol; $colIndex--) {
                        if (!$tablero->seldaVacia($inFila, $colIndex)) {
                            $piezaEnMedio = true;
                        }
                    }

                    if (!$piezaEnMedio) {
                        //Si no hay, comprobar si cae sobre una pieza rival
                        if ($tablero->seldaVacia($finFila, $finCol)) {
                            return true;

                        } else {
                            $pieza = $tablero->getPieza($finFila, $finCol);

                            if ($pieza->getColor() !== $this->color) {
                                return true;

                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                }
            }
        }

    }
}

?>