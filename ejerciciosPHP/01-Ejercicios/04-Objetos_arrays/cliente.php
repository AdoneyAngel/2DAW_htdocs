<?php
    require "persona.php";

    class Cliente extends Persona {

        private $saldo = 0;

        function __construct($DNI, $nombre, $apellido, $saldo) {
            parent::__construct($DNI, $nombre, $apellido);
            $this->saldo = $saldo;
        }

        public function getSaldo() {
            return $this->saldo;
        }

        public function setSaldo($saldo) {
            $this->saldo = $saldo;
        }

        public function __toString() {
            return "Cliente: " . $this->getNombre();
        }

    }
?>
