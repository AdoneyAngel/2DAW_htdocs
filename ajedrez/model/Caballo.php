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
        
    }
}

?>