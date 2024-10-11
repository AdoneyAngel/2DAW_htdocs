<?php
require_once("../Model/FranjaHorario.php");
require_once("../Model/Modulo.php");
require_once("../Model/Campos.php");
require_once("../Model/Validaciones.php");

class GestorHorario
{
    private $rutaDatos = "..\Horario\horarios.dat";
    private $rutaCarpetaDatos = "../Horario/";
    private $horario;

    public function __construct() {
        $this->cargarDatos();

    }

    public function insertarHora($franja) {
        try {
            //Comprobar el tipo para asignarle un color (recreo azul claro y no lectivas azul)
            if ($franja->getTipoFranja() == TipoFranja::Recreo) {
                $franja->setColor(Color::AzulClaro);
                $franja->getModulo()->setMateria(Materia::RECREO);

            } else if(!franjaLectiva($franja)) {
                $franja->setColor(Color::Azul);
            }

            if (validarInsertarFranja($franja, $this->horario)) {
                $this->horario[] = $franja;

                $this->guardarHorario();
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function eliminarHora($franja) {

    }
    public function subirFichero($rutaFicheroSubido) {

    }
    public function generarHorario($tipoHorario) {

    }

    public function mostrarHorario() {
        foreach (Hora::cases() as $horaActual) {//Cada hora (1->primera, 2->segunda, ...)

            echo "<tr style='place-content: center'>"; //Se abre la etiqueta de linea

            //Se inserta primero la columna de la hora
            echo "<th>"; 
                echo "<p class='fw-normal'>";
                    echo $horaActual->value;
                echo "<p>";
            echo "</th>"; 

            foreach (Semana::cases() as $diaActual) {//Cada dia (1->Lunes, 2->Martes, ...)
                $franjaActual = $this->getFranja($horaActual, $diaActual);

                if ($franjaActual) {

                    //Se abre la etiqueta columna, teniendo el tipo de franja para su color
                    if ($franjaActual->getTipoFranja() == TipoFranja::Recreo) {
                        echo "<th style='place-content: center; background:".Color::AzulClaro->value."'>";

                    } else if ($franjaActual->getTipoFranja() !== TipoFranja::Lectiva) {
                        echo "<th style='place-content: center; background:".Color::Azul->value."'>";

                    } else {
                        echo "<th style='place-content: center; background:".$franjaActual->getColor()->value."'>";

                    }

                    if (franjaLectiva($franjaActual)) {
                        echo "<p style='margin:auto' class='text-center fw-normal'>"; //Curso
                            echo $franjaActual->getModulo()->getCurso()->value;
                        echo "</p>";

                        echo "<p style='margin:auto' class='text-center fw-normal'>"; //Asignatura
                            echo $franjaActual->getModulo()->getMateria()->value;
                        echo "</p>";

                        echo "<p style='margin:auto' class='text-center fw-normal'>"; //Clase
                            echo $franjaActual->getModulo()->getClase()->value;
                        echo "</p>";

                    } else {
                        echo "<p style='margin:auto' class='text-center fw-normal'>"; //Asignatura
                            echo $franjaActual->getModulo()->getMateria()->value;
                        echo "</p>";
                    }

                } else {
                    echo "<th>"; //Se abre la eitqueta de columna (En este caso es para los huecos vacios)
                    echo "<p></p>";
                }

                echo "</th>";
            }

            echo "</tr>";
        }
    }

    private function guardarHorario() {
        $nuevaStr = "";

        foreach ($this->horario as $franjaActual) {

            //Se carga el curso
            if ($franjaActual->getTipoFranja() == TipoFranja::Lectiva) {
                $nuevaStr .= $franjaActual->getModulo()->getCurso()->value . ";";

            } else {
                $nuevaStr .= "_;";
            }

            //Se carga el dia
            $nuevaStr .= $franjaActual->getDia()->value . ";";

            //Se carga la hora
            $nuevaStr .= $franjaActual->getHora()->codigoHora() . ";";

            //Se carga la materia
            $nuevaStr .= $franjaActual->getModulo()->getMateria()->value . ";";

            //Se carga la clase
            if ($franjaActual->getTipoFranja() == TipoFranja::Lectiva) {
                $nuevaStr .= $franjaActual->getModulo()->getClase()->value . ";";   

            } else {
                $nuevaStr .= "_;";
            }
            
            //Cargar color
            $nuevaStr .= $franjaActual->getColor()->value . ";";

            //Cargar tipo
            $nuevaStr .= $franjaActual->getTipoFranja()->value . "@";

        }

        validarCarpetaDatos();//Se valida que la carpeta de datos esta y se crea automaticamente

        //Se almacena el string al fichero de datos
        $ficheroDatos = fopen($this->rutaDatos, "w");

        fwrite($ficheroDatos, $nuevaStr);

        fclose($ficheroDatos);
    }

    private function getFranja($hora /*tipo Hora*/, $dia /*tipo Semana*/) {
        if ($this->horario) {
            foreach ($this->horario as $franjaActual) {
                if ($franjaActual->getHora() == $hora && $franjaActual->getDia() == $dia) {
                    return $franjaActual;
                }
            }            
        }

        return null;
    }

    private function cargarDatos() { //Comprueba que horarios.dat existe y lo introduce en $horario, si no, lo crea

        if (validarFicheroDatos()) {
            $contenidoFicheroDatos = file_get_contents($this->rutaDatos);

            $this->horario = $this->dataStringToArray($contenidoFicheroDatos);
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

        $horas = Hora::cases();

        return $horas[$codigoHora];

    }
}