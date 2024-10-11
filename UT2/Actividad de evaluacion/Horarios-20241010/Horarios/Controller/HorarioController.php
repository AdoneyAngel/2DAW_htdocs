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
                    $this->showErr("Error Campos: El campo no puede estar vacío.");
                }
            }

            if (isset($_POST['eliminar'])) {

            }

            if (isset($_POST['cargar'])) {
         
            }

            if (isset($_POST['generar'])){
        
            }
        } catch (Exception $e) {
            echo '<p style="color:red">Excepción: ', $e->getMessage(), "</p><br>";
        }
    }

    function mostrarHorario(){
        $this->gestorHorario->mostrarHorario();
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
            $this->showErr($e->getMessage());
        }
    }

    private function showErr($error) {
        echo "<p>Error Horario: $error</p>";
    }
}