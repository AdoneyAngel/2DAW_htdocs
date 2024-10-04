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
        
    }
}

?>