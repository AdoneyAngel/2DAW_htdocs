<?php

require_once("../Model/FranjaHorario.php");
require_once("../Model/Modulo.php");
require_once("../Model/Campos.php");

class GestorHorario
{
    private $rutaDatos = "..\Horario\horarios.dat";
    private $rutaCarpetaDatos = "../Horario/";
    private $horario;

    public function __construct() {
        $this->cargarDatos();

    }

    public function insertarHora($franja) {
        
    }

    private function cargarDatos() { //Comprueba que horario.dat existe y lo introduce en $horario, si no, lo crea
        if (file_exists($this->rutaDatos)) {
            $contenidoFicheroDatos = file_get_contents($this->rutaDatos);

            $this->horario = $this->dataStringToArray($contenidoFicheroDatos);

        } else {
            if (is_dir($this->rutaCarpetaDatos)) {
                $ficheroDatos = fopen($this->rutaDatos, "w");
                fclose($ficheroDatos);

            } else {
                mkdir($this->rutaCarpetaDatos,0755, true);

                $ficheroDatos = fopen($this->rutaDatos, "w");
                fclose(stream: $ficheroDatos);
            }
        }

    }

    private function dataStringToArray($dataString) {
        if (empty($dataString)) {
            return false;
        }

        $horarioArray = array();
        $franjasStr = explode("@", $dataString);

        foreach ($franjasStr as $franjaStrActual) {
            $franjaStrActual = trim($franjaStrActual);

            if (empty($franjaStrActual)) {
                continue;
            }

            preg_match('/([^;]+);([^;]+);([^;]+);([^;]+);([^;]+);([^;]+);([^;]+)/', $franjaStrActual, $franjaActualDelimitada);

            $franja_curso = trim($franjaActualDelimitada[1]);
            $franja_dia = trim($franjaActualDelimitada[2]);
            $franja_hora = trim($franjaActualDelimitada[3]);
            $franja_materia = trim($franjaActualDelimitada[4]);
            $franja_clase = trim($franjaActualDelimitada[5]);
            $franja_color = trim($franjaActualDelimitada[6]);
            $franja_tipo = trim($franjaActualDelimitada[7]);

            $modulo = null;

            if ($franja_tipo === "L" && !empty($franjaStrActual)) {
                $modulo = new Modulo(Curso::from($franja_curso), Materia::from($franja_materia), Clase::from($franja_clase));

            } else if (!empty($franjaStrActual)){
                $modulo = new Modulo("", Materia::from($franja_materia), "");
            }

            $franja = new FranjaHorario($modulo, Semana::from($franja_dia), Hora::from($this->getHorarioHora($franja_hora)->value), TipoFranja::from($franja_tipo), Color::from($franja_color));

            $horarioArray[] = $franja;

        }

        return $horarioArray;
    }

    private function getHorarioHora($codigoHora) {
        $codigoHora--;


        $horas = [
            Hora::Primera,
            Hora::Segunda,
            Hora::Tercera,
            Hora::Cuarta,
            Hora::Quinta,
            Hora::Sexta,
            Hora::Septima,
            Hora::Octava,
            Hora::Novena,
            Hora::Decima,
            Hora::Onceava,
            Hora::Doceava,
            Hora::Treceava,
            Hora::Catorceava
        ];

        return $horas[$codigoHora];

    }
}