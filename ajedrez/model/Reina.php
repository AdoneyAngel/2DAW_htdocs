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
        
    }
}

?>