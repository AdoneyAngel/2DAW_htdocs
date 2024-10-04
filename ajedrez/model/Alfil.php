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
        
    }
}

?>