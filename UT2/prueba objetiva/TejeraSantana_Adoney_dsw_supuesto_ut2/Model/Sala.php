<?php

require_once "../Model/Validaciones.php";
require_once "../Model/Asiento.php";

class Sala
{
    private $MapaSala;
    private $RutaFichero;
    private $TipoSala;

    public function __construct() {
        $this->MapaSala = array();
    }

    public function getMapaSala() {
        return $this->MapaSala;
    }
    public function setMapaSala($MapaSala) {
        $this->MapaSala = $MapaSala;
    }
    public function getTipoSala() {
        return $this->TipoSala;
    }
    public function setTipoSala($TipoSala) {
        $this->TipoSala = $TipoSala;
    }
    public function getRutaFichero() {
        return $this->RutaFichero;
    }
    public function setRutaFichero($RutaFichero) {
        $this->RutaFichero = $RutaFichero;
    }

    public function cargarDatosSala() {
        //Se vacía la tabla por si se ejecuta mas de 1 vez el método
        $this->MapaSala = array();

        $validaciones = new Validaciones();
        $validaciones->validarFicherosDatos();

        //comprobar que tiene la ruta del fichero
        if (!isset($this->RutaFichero) || empty($this->RutaFichero)) {
            throw new Exception("Se debe establecer la ruta de fichero");
        } 

        //cargar los datos
        $ficheroContenido = file_get_contents($this->RutaFichero);

        if (empty($ficheroContenido)) {
            throw new Exception("La sala está vacía de contenido");
        }

        $tipoSala = explode("#", $ficheroContenido)[0];
        $filasStr = explode("#", $ficheroContenido)[1];
        $filas = explode("@", $filasStr); 

        //Se recorre cada fila
        foreach ($filas as $filaPos => $fila) {
            if (empty($fila)) {//Se ignora un campo vacio como un salto de linea o algun error en la estructura
                continue;
            }

            //Se recorre cada uno de los asientos de la fila
            $asientos = str_split($fila);

            foreach ($asientos as $asientoPos => $asiento) {
                $asientoFila = $filaPos;
                $asientoColumna = $asientoPos;
                $asientoTipo = tipoAsiento::from($asiento);

                $nuevoAsiento = new Asiento($asientoTipo, $asientoFila, $asientoColumna);

                $this->MapaSala[] = $nuevoAsiento;
            }
        }
    }

    public function comprarAsiento($asiento) {

    }

    public function reservarAsiento($asiento) {

    }

    public function cancelarAsiento($asiento) {

    }

    public function importarDatosSala($ficheroDatos) {

    }

    public function mostrarMapaSala() {
            //Crear tabla
            //Se obtiene cual será el ancho del mapa
            $dimensiones = $this->getDimensiones();

            echo "<table border='2'>";

                //Se crea los números de las columnas
                echo "<thead>";
                    echo "<tr>";
                        for ($col = 0; $col<$dimensiones["x"]; $col++) {
                            echo "<th>";
                                echo $col;
                            echo "</th>";
                        }                    
                    echo "</tr>";
                echo "</thead>";

                //Se crea cada una de las filas
                echo "<tbody>";
                
                        for ($filaIndex = 0; $filaIndex<$dimensiones["y"]; $filaIndex++) {
                            echo "<tr>";
                                //Se añade la primera columna, el nº de la fila
                                echo "<th>$filaIndex</th>";

                                //se recorre las columnas
                                for ($colIndex = 0; $colIndex<$dimensiones["x"]; $colIndex++) {
                                    $asientoActual = $this->getAsiento($filaIndex, $colIndex);

                                    if (isset($asientoActual) && !empty($asientoActual)) {
                                        $imagen = "";

                                        switch($asientoActual->getTipo()){
                                            case tipoAsiento::Disponible:
                                                $imagen = "../Datos/img/disponible.png";
                                                break;
                                            case tipoAsiento::Ocupado:
                                                $imagen = "../Datos/img/ocupado.png";
                                                break;
                                            case tipoAsiento::Reservado:
                                                $imagen = "../Datos/img/reservado.png";
                                                break;
                                            case tipoAsiento::Minusvalido_Libre:
                                                $imagen = "../Datos/img/rueda_libre.jpg";
                                                break;
                                            case tipoAsiento::Minusvalido_Ocupado:
                                                $imagen = "../Datos/img/rueda_ocupada.jpg";
                                                break;
                                            case tipoAsiento::Libre:
                                                $imagen = "../Datos/img/libre.png";
                                                break;
                                            default:
                                                $imagen = "../Datos/img/libre.png";
                                        }

                                        echo '<th><img src="'.$imagen.'" with="30" height="30" alt="libre"></th>';
                                    }
                                }

                            echo "</tr>";
                        }

                echo "</tbody>";

            echo "</table>";
    }

    private function getDimensiones() {
        if (!isset($this->MapaSala) || empty($this->MapaSala)) {
            throw new Exception("Debe inicializar el mapa de la sala");
        }

        //Se almacenan todos los asientos filtrados por fila
        $filas = array();

        foreach ($this->MapaSala as $asiento) {
            $filas[$asiento->getFila()][] = $asiento;
        }

        $dimensiones = [
            "x" => 0,
            "y" => count($filas)
        ];

        //Buscar cual de todas las filas tienen mas asientos
        foreach($filas as $fila) {
            if (count($fila) > $dimensiones["x"]) {
                $dimensiones["x"] = count($fila);
            }
        }

        return $dimensiones;
    }

    private function getAsiento($fila, $columna) {
        foreach($this->MapaSala as $asiento) {
            if ($asiento->getFila() == $fila && $asiento->getColumna() == $columna) {
                return $asiento;
            }
        }

        return null;
    }
}