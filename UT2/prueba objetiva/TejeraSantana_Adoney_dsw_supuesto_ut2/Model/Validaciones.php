<?php

    class Validaciones {
        private $rutaSala1 = "../Datos/salas/sala2.dat";
        private $rutaSala2 = "../Datos/salas/sala3.dat";
        private $rutaSala3 = "../Datos/salas/sala4.dat";
        private $rutaSala4 = "../Datos/salas/sala1.dat";
        private $rutaCarpetaDatos = "../Datos/";
        private $rutaCarpetaSalas = "../Datos/salas";
        
        public function __construct() {
        }

        public function validarDatosMostrar() {
            if (!isset($_POST["sala"]) || empty($_POST["sala"])) {
                throw new Exception("Debe envíar una sala válida");
            }
        }

        public function validarFicherosDatos() {
            //Se valida su carpeta
            $this->validarCarpetaDatos();

            //Se valida que existe cada fichero, si no, los crea
            if (!is_file($this->rutaSala1)) {
                $sala = fopen($this->rutaSala1,"w");
                fwrite($sala, "");
                fclose($sala);
            }
            if (!is_file($this->rutaSala2)) {
                $sala = fopen($this->rutaSala2,"w");
                fwrite($sala, "");
                fclose($sala);
            }
            if (!is_file($this->rutaSala3)) {
                $sala = fopen($this->rutaSala3,"w");
                fwrite($sala, "");
                fclose($sala);
            }
            if (!is_file($this->rutaSala4)) {
                $sala = fopen($this->rutaSala4,"w");
                fwrite($sala, "");
                fclose($sala);
            }
        }

        public function validarCarpetaDatos() {
            if (!is_dir($this->rutaCarpetaDatos)) {
                mkdir($this->rutaCarpetaDatos, 755, true);

            }
            if (!is_dir($this->rutaCarpetaSalas)) {
                mkdir($this->rutaCarpetaSalas, 755, true);
            }
        }

        public function validarDatosImportar() {
            if (!isset($_POST["salaImport"]) || empty($_POST["salaImport"])) {
                throw new Exception("Se debe seleccionar una sala para importar");
            }
            if (!isset($_FILES["fsala"]) || !is_file($_FILES["fsala"]["tmp_name"]) || empty($_FILES["fsala"])) {
                throw new Exception("Se debe seleccionar un fichero para importar");
            }
        }
    }

?>