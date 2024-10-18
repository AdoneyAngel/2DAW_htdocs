<?php
require_once("../Model/FranjaHorario.php");
require_once("../Model/Modulo.php");
require_once("../Model/Campos.php");
require_once("../Model/Validaciones.php");

class GestorHorario
{
    private $rutaDatos = "..\Horarios\horarios.dat";
    private $rutaCarpetaDatos = "../Horarios/";
    private $horario;

    public function __construct() {
        $this->cargarDatos();

    }

    public function getHorario() {
        return $this->horario;
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
        try {
            if(validarEliminarFranja($franja, $this->horario)) {
                $this->eliminarFranja($franja);
                $this->guardarHorario();
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function subirFichero($rutaFicheroSubido) {

        //Truncar fichero temporal al fichero de datos
        $contenidoFichero = file_get_contents($rutaFicheroSubido);

        $ficheroDatos = fopen($this->rutaDatos, "w");
        fwrite($ficheroDatos, $contenidoFichero);
        fclose($ficheroDatos);

        //Se vuelve a cargar los datos del fichero
        $this->cargarDatos();
    }
    public function generarHorario($tipoHorario) {
        // $maxLectivas = 18;
        // $maxNoLectiva = 6;
        // $maxRD = 1;//reuniones de departamento
        // $maxTutoria = 1;

        $nuevoHorario = array();

        //Generar recreos
        $this->generarRecreos($tipoHorario, $nuevoHorario);

        //Generar horas lectivas
        $this->generarLectivas($tipoHorario, $nuevoHorario);

        //Generar horas no lectivas
        $this->generarNoLectivas($tipoHorario, $nuevoHorario);

        //Se establece el horario y se guarda
        $this->horario = $nuevoHorario;
        $this->guardarHorario();

    }

    private function generarNoLectivas($tipoHorario, &$horario) {
        $rangoHoras = array();
        $nNoLectivas = 0;
        $maxNoLectivas = 6;

        //Ajustar el rango de horas dependiendo del tipo de horario
        if ($tipoHorario == TiposHorarios::Mañana) {
            $rangoHoras["min"] = 0;
            $rangoHoras["max"] = 6;

        } else if ($tipoHorario == TiposHorarios::Tarde) {
            $rangoHoras["min"] = 7;
            $rangoHoras["max"] = 13;

        } else {
            $rangoHoras["min"] = 0;
            $rangoHoras["max"] = 13;
        }

        while ($nNoLectivas < $maxNoLectivas) {
            $randCurso = rand(0, count(Curso::cases())-1);
            $randMateria = rand(0, count(Materia::cases())-1);
            $randClase = rand(0, count(Clase::cases())-1);
            $randDia = rand(0, count(Semana::cases())-1);
            $randHora = rand($rangoHoras["min"]+1, max: $rangoHoras["max"]+1);

            //Atributos aleatorios modulo
            $curso = $this->getHorarioCurso($randCurso);
            $materia = $this->getHorarioMateria($randMateria);
            $clase = $this->getHorarioClase($randClase);

            //Atributos aleatorios franja
            $dia = $this->getHorarioDia($randDia);
            $hora = $this->getHorarioHora($randHora);
            $tipo = TipoFranja::Complementaria;
            $color = Color::Azul;

            //Objeto franja
            $modulo = new Modulo($curso, $materia, $clase);
            $franja = new FranjaHorario($modulo, $dia, $hora, $tipo, $color);

            try {
                if (materiaLectiva($materia)) {
                    validarInsertarFranja($franja, $horario);
                    $horario[] = $franja;
                    $nNoLectivas++;                          
                }

            } catch (Exception $e) {
            }
        }
    }

    private function generarLectivas($tipoHorario, &$horario) {
        $rangoHoras = array();
        $nLectivas = 0;
        $maxLectivas = 18;

        //Ajustar el rango de horas dependiendo del tipo de horario
        if ($tipoHorario == TiposHorarios::Mañana) {
            $rangoHoras["min"] = 0;
            $rangoHoras["max"] = 6;

        } else if ($tipoHorario == TiposHorarios::Tarde) {
            $rangoHoras["min"] = 7;
            $rangoHoras["max"] = 13;

        } else {
            $rangoHoras["min"] = 0;
            $rangoHoras["max"] = 13;
        }

        while ($nLectivas < $maxLectivas) {
            $randCurso = rand(0, count(Curso::cases())-1);
            $randMateria = rand(0, count(Materia::cases())-1);
            $randClase = rand(0, count(Clase::cases())-1);
            $randDia = rand(0, count(Semana::cases())-1);
            $randHora = rand($rangoHoras["min"]+1, max: $rangoHoras["max"]+1);
            $randColor = rand(0, count(Color::cases())-1);

            //Atributos aleatorios modulo
            $curso = $this->getHorarioCurso($randCurso);
            $materia = $this->getHorarioMateria($randMateria);
            $clase = $this->getHorarioClase($randClase);

            //Atributos aleatorios franja
            $dia = $this->getHorarioDia($randDia);
            $hora = $this->getHorarioHora($randHora);
            $tipo = TipoFranja::Lectiva;
            $color = $this->getHorarioColor($randColor);

            //Objeto franja
            $modulo = new Modulo($curso, $materia, $clase);
            $franja = new FranjaHorario($modulo, $dia, $hora, $tipo, $color);

            try {
                if (franjaLectiva($franja) && $color != Color::Azul && $color != Color::AzulClaro) {
                    validarInsertarFranja($franja, $horario);
                    $horario[] = $franja;
                    $nLectivas++;                    
                }

            } catch (Exception $e) {
            }
        }

    }

    private function generarRecreos($tipoHorario, &$horario) {
        $modulo = new Modulo(Curso::DAM_1A, Materia::RECREO, Clase::C205);

        if ($tipoHorario == TiposHorarios::Mañana || $tipoHorario == TiposHorarios::Mixto) {//Mañana
            for ($diaIdx = 0; $diaIdx<5; $diaIdx++) {
                $diaActual = $this->getHorarioDia($diaIdx);
                $hora = Hora::Cuarta;
                $tipoFranja = TipoFranja::Recreo;
                $color = Color::AzulClaro;

                $franjaActual = new FranjaHorario($modulo, $diaActual, $hora, $tipoFranja, $color);

                $horario[] = $franjaActual;
            }
        }

        if ($tipoHorario == TiposHorarios::Tarde || $tipoHorario == TiposHorarios::Mixto) {//Tarde
            for ($diaIdx = 0; $diaIdx<5; $diaIdx++) {
                $diaActual = $this->getHorarioDia($diaIdx);
                $hora = Hora::Onceava;
                $tipoFranja = TipoFranja::Recreo;
                $color = Color::AzulClaro;

                $franjaActual = new FranjaHorario($modulo, $diaActual, $hora, $tipoFranja, $color);

                $horario[] = $franjaActual;
            }
        }
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
                    $colorTexto = $franjaActual->getColor() == Color::AzulOscuro ? 'white':'black';

                    //Se abre la etiqueta columna, teniendo el tipo de franja para su color
                    if ($franjaActual->getTipoFranja() == TipoFranja::Recreo) {
                        echo "<th style='place-content: center; background:".Color::AzulClaro->value."'>";

                    } else if ($franjaActual->getTipoFranja() !== TipoFranja::Lectiva) {
                        echo "<th style='place-content: center; background:".Color::Azul->value."'>";

                    } else {
                        echo "<th style='color: ".$colorTexto.";place-content: center; background:".$franjaActual->getColor()->value."'>";

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

    private function eliminarFranja($franja) {
        foreach ($this->horario as $franjaIndex => $franjaActual) {
            if ($franjaActual == $franja) {
                unset($this->horario[$franjaIndex]);
            }
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
    private function getHorarioDia($index) {
        $dias = Semana::cases();

        return $dias[$index];
    }
    private function getHorarioMateria($index) {
        $materias = Materia::cases();

        return $materias[$index];
    }
    private function getHorarioClase($index) {
        $clases = Clase::cases();

        return $clases[$index];
    }
    private function getHorarioCurso($index) {
        $cursos = Curso::cases();

        return $cursos[$index];
    }
    private function getHorarioColor($index) {
        $colores = Color::cases();

        return $colores[$index];
    }
}