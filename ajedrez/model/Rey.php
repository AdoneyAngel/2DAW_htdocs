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
        
    }
}

?>