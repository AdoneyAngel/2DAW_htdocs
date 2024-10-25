<?php
    require_once "../Model/Validaciones.php";
    require_once "../Model/Sala.php";

    class ProcesarController {
        public function __construct() {
            $validaciones = new Validaciones();

            try {

                if (isset($_POST["mostrar"])) {
                    $validaciones->validarDatosMostrar();
                    
                    $this->mostrarSala();
                }
                if (isset($_POST["importar"])) {
                    $validaciones->validarDatosImportar();

                    $this->importarSala();

                    $this->mostrarSala();
                }

            } catch(Exception $e) {
                echo $e->getMessage();
            }

        }

        public function mostrarSala() {
            $rutaSala1 = "../Datos/salas/sala1.dat";
            $rutaSala2 = "../Datos/salas/sala2.dat";
            $rutaSala3 = "../Datos/salas/sala3.dat";
            $rutaSala4 = "../Datos/salas/sala4.dat";

            //Se valida que los ficheros existen
            $validaciones = new Validaciones();
            $validaciones->validarFicherosDatos();

            $sala = new Sala();

            $salaSeleccionada = $_POST["sala"];

            //Comprobar si ha habido una importacion anteriormente, si se importó algo entonces muestra la sala modificada

            if (isset($_POST["importar"])) {
                if (isset($_POST["salaImport"]) && !empty($_POST["salaImport"])) {
                    $salaSeleccionada = $_POST["salaImport"];
                }
            }

            switch ($salaSeleccionada) {
                case salaEnum::Sala1->name:
                    $sala->setRutaFichero($rutaSala1);
                    break;
                case salaEnum::Sala2->name:
                    $sala->setRutaFichero($rutaSala2);
                    break;
                case salaEnum::Sala3->name:
                    $sala->setRutaFichero($rutaSala3);
                    break;
                case salaEnum::Sala4->name:
                    $sala->setRutaFichero($rutaSala4);
                    break;

                default:
                    throw new Exception("Sala introducida inválida");

            }

            $sala->cargarDatosSala();
            $sala->mostrarMapaSala();

        }

        private function importarSala() {
            //Se valida que existan las carpetas necesarias
            $validaciones = new Validaciones();
            $validaciones->validarCarpetaDatos();

            $rutaSala1 = "../Datos/salas/sala1.dat";
            $rutaSala2 = "../Datos/salas/sala2.dat";
            $rutaSala3 = "../Datos/salas/sala3.dat";
            $rutaSala4 = "../Datos/salas/sala4.dat";

            $salaSeleccionada = $_POST["salaImport"];
            $ficheroSeleccionado = $_FILES["fsala"];
            $rutaModificar = "";

            switch ($salaSeleccionada) {
                case salaEnum::Sala1->name:
                    $rutaModificar = $rutaSala1;
                    break;
                case salaEnum::Sala2->name:
                    $rutaModificar = $rutaSala2;
                    break;
                case salaEnum::Sala3->name:
                    $rutaModificar = $rutaSala3;
                    break;
                case salaEnum::Sala4->name:
                    $rutaModificar = $rutaSala4;
                    break;
                default:
                    throw new Exception("Se ha envíado una sala inválida");
            }

            //Se abre, sustituye el fichero de datos con el nuevo fichero y se cierran
            $sala = fopen($rutaModificar, "w");

            $contenidoFicheroSubido = file_get_contents($ficheroSeleccionado["tmp_name"]);

            fwrite($sala, $contenidoFicheroSubido);

            fclose($sala);

        }
    }

    // Mostrar Sala

    // Comprar Asientos
 
    // Reservar Asientos

    // Cancelar Asientos

    // Importar Ficheros de Salas

    ?>