<?php

require_once "../Model/GestorHorario.php";
require_once "../Model/Validaciones.php";
require_once "../Model/Modulo.php";
require_once "../Model/FranjaHorario.php";

class HorarioController{

    private $gestorHorario;

    function __construct(){
        $this->gestorHorario = new GestorHorario();

        try {
            if (isset($_POST['insertar'])) {
                if (validarDatosInsertar()) {
                    $this->insertarHora();
                    
                } else {
                    $this->showHorarioErr("Error Campos: El campo no puede estar vacío.");
                }
            }

            if (isset($_POST['eliminar'])) {
                if (validarDatosEliminar()) {
                    $this->eliminarHora();

                } else {
                    $this->showHorarioErr("Error Campos: El campo no puede estar vacío.");
                }
            }

            if (isset($_POST['cargar'])) {
                if (validarDatosCargar()) {
                    $this->cargarHorario();

                } else {
                    $this->showHorarioErr('El fichero no puede estar vacío.');
                }
            }

            if (isset($_POST['generar'])){
                if (validarDatosGenerar()) {
                    $this->gestorHorario->generarHorario(TiposHorarios::from($_POST["tipohorario"]));

                } else {
                    $this->showErr('El horario no ha podido generarse correctamente.');
                } 
            }

        } catch (Exception $e) {
            echo '<p style="color:red">Excepción: ', $e->getMessage(), "</p><br>";
        }
    }

    function mostrarHorario(){
        $this->gestorHorario->mostrarHorario();
    }

    private function cargarHorario() {
        $rutaDatosTemporales = "../datos_temporales/datos_temp.dat";
        $ficheroSubido = $_FILES["fhorario"];


        //Mover fichero a la carpeta de datos temporales
        move_uploaded_file($ficheroSubido["tmp_name"], $rutaDatosTemporales);

        //Gestor horario cogera el fichero de la carpeta temporal y lo truncara
        $this->gestorHorario->subirFichero($rutaDatosTemporales);
    }

    private function insertarHora() {
        $datosForm = [
            "curso" => $_POST["curso"],
            "color" => $_POST["color"],
            "materia" => $_POST["materia"],
            "tipoFranja" => $_POST["tipoFranja"],
            "hora" => $_POST["hora"],
            "dia" => $_POST["dia"],
            "clase" => $_POST["clase"],
        ];

        $curso = Curso::from($datosForm["curso"]);
        $color = Color::from($datosForm["color"]);
        $materia = Materia::from($datosForm["materia"]);
        $tipoFranja = TipoFranja::from($datosForm["tipoFranja"]);
        $hora = Hora::from($datosForm["hora"]);
        $dia = Semana::from($datosForm["dia"]);
        $clase = Clase::from($datosForm["clase"]);

        $modulo = new Modulo($curso, $materia, $clase);
        $franja = new FranjaHorario($modulo, $dia, $hora, $tipoFranja, $color);

        try {
            $this->gestorHorario->insertarHora($franja);

        } catch (Exception $e) {
            $this->showHorarioErr($e->getMessage());
        }
    }

    private function eliminarHora() {
        $datosForm = [
            "hora" => $_POST["hora"],
            "dia" => $_POST["dia"]
        ];

        $hora = Hora::from($datosForm["hora"]);
        $dia = Semana::from($datosForm["dia"]);

        $franja = $this->getFranja($hora, $dia);

        try {
            $this->gestorHorario->eliminarHora($franja);

        } catch (Exception $e) {
            $this->showEliminarErr($e->getMessage());
        }
        
    }

    private function showHorarioErr($error) {
        echo "<p>Error Horario: $error</p>";
    }
    private function showEliminarErr($error) {
        echo "<p>Error Eliminar hora: $error</p>";
    }
    private function showErr($error) {
        echo "<p>$error</p>";
    }

    private function getFranja($hora /*tipo Hora*/, $dia /*tipo Semana*/) {
        if ($this->gestorHorario->getHorario()) {
            foreach ($this->gestorHorario->getHorario() as $franjaActual) {
                if ($franjaActual->getHora() == $hora && $franjaActual->getDia() == $dia) {
                    return $franjaActual;
                }
            }            
        }

        return null;
    }
}