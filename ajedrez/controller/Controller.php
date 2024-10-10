<?php

require_once("./model/Tablero.php");

class Controller {
    
    private $rutaCarpetaDatos;
    private $rutaDatos;
    private $movimientos;
    private $tablero;

    public function __construct() {
        $this->rutaCarpetaDatos = "./data/";
        $this->rutaDatos = "./data/movimientos.txt";

        $this->tablero = new Tablero();
        $this->tablero->inicializar();

        //Se carga el archivo de movimientos, posteriormente se establecen dichos movimientos
        $this->cargarArchivo();
        $this->establecerMovimientos();

        //Se carga el movimiento enviado por formulario
        $this->obtenerMovimientoForm();
    }

    private function guardarMovimiento($pieza, $prevPos, $newPos) {
        $dataString = "\n".$pieza->getFullName().":"."[".$prevPos[0].",".$prevPos[1]."]:[".$newPos[0].",".$newPos[1]."]";

        $archivoDatos = fopen($this->rutaDatos, "a");

        fwrite($archivoDatos, $dataString);

        fclose($archivoDatos);
    }

    private function obtenerMovimientoForm() {
        if (isset($_POST["inFila"]) && isset($_POST["inCol"]) && isset($_POST["finFila"]) && isset($_POST["finCol"])) {
            $inFila = $_POST["inFila"];
            $inCol = $_POST["inCol"];
            $finFila= $_POST["finFila"];
            $finCol = $_POST["finCol"];

            //Comprobar que las coordenadas no estén vacios
            if (strlen($inFila)>0 && strlen($inCol)>0 && strlen($finFila)>0 && strlen($finCol)>0) {

                //Comprobar que las coordenadas están dentro de la tabla
                if ($inFila < 0 || $inFila > 7
                    || $inCol < 0 || $inCol > 7
                    || $finFila < 0 || $finFila > 7
                    || $finCol < 0 || $finCol > 7) {
                        echo "Las coordenadas no están dentro de la tabla";
                        return false;

                }

                if (!$this->tablero->seldaVacia($inFila, $inCol)) {
                    $piezaInicial = $this->tablero->getPieza($inFila, $inCol);

                    $newPos = [$finFila, $finCol];
                    $prevPos = [$inFila, $inCol];

                    $movimientoValido = $piezaInicial->validateMove($prevPos, $newPos, $this->tablero);
                    
                    if ($movimientoValido) {
                        $this->tablero->mover($inFila, $inCol, $finFila, $finCol);
                        $this->guardarMovimiento($piezaInicial, $prevPos, $newPos);
                        
                    } else {
                        echo "Movimiento invalido";
                    }
                }

            } else {
                echo "Faltan datos";
            }
        }
    }

    private function establecerMovimientos() {
        if ($this->movimientos) {
            foreach ($this->movimientos as $movimientoActual) {
                $inFila = $movimientoActual[2];
                $inCol = $movimientoActual[3];
                $finFila = $movimientoActual[4];
                $finCol = $movimientoActual[5];

                $this->tablero->getPieza($inFila, $inCol)->siguientePaso();
                $this->tablero->mover($inFila, $inCol, $finFila, $finCol);
            }
        }
    }

    private function cargarArchivo() {
        //Comprobar si el usuario ha subido un fichero
        if (isset($_FILES["archivoMovimientos"])) {
            $ficheroTmp = $_FILES["archivoMovimientos"];

            move_uploaded_file($ficheroTmp["tmp_name"], $this->rutaDatos);
        }

        //Comprobar que la carpeta de datos existe o crearlo
        if (!file_exists($this->rutaCarpetaDatos)) {
            mkdir($this->rutaCarpetaDatos,0755, true);
        }

        //Comprobar que el archivo de datos existe o crearlo
        if (file_exists($this->rutaDatos)) {
            $contenidoDatos = file($this->rutaDatos, FILE_SKIP_EMPTY_LINES);

            $movimientos = array();

            foreach ($contenidoDatos as $filaActual) {
                preg_match("/(\w+):\[(\d+),(\d+)\]:\[(\d+),(\d+)\]/", $filaActual, $movimientoActual);

                if ($movimientoActual) {
                    $movimientos[] = $movimientoActual; 
                }
                 
            }

            $this->movimientos = $movimientos;
            
        } else {
            $archivoDatos = fopen($this->rutaDatos, "w");
            fwrite($archivoDatos, "");
            fclose($archivoDatos);

            $this->movimientos = null;
        }
    }

    public function tablaHtml() {
        echo "<table>";

        echo "<th>";
            //Header de la tabla
            for ($columna = 0; $columna<=7; $columna++) {
                echo "<td>$columna</td>";
            }
        
        echo "</th>";

        //Contenido de tablero
        for($fila = 0; $fila<=7; $fila++) {
            echo "<tr>";

                //Numero de fila
                echo "<td>$fila</td>";

                for ($columna = 0; $columna <= 7; $columna++) {

                    $claseComponente = "";

                    //Establecer la clase de la selda
                    if (($columna + $fila) % 2 == 0) {
                        $claseComponente = "blanco";

                    } else {
                        $claseComponente = "negro";
                    }

                    if (!$this->tablero->seldaVacia($fila, $columna)) {
                        $piezaActual = $this->tablero->getPieza($fila, $columna);
                        $icon = "";
                        $claseColorPieza = $piezaActual->getColor() === "negro" ? "piezaNegra" : "piezaBlanca";

                        switch ($piezaActual->getName()) {
                            case "peon":
                                $icon = "♟";
                                break;
                            case "torre":
                                $icon = "♜";
                                break;
                            case "caballo":
                                $icon = "♞";
                                break;
                            case "alfil":
                                $icon = "♝";
                                break;
                            case "rey":
                                $icon = "♚";
                                break;
                            case "reina":
                                $icon = "♛";
                                break;
                        }

                        echo "<td class='$claseComponente $claseColorPieza selda pieza' id='".$fila."_".$columna."'><p>$icon</p></td>";

                    } else {
                        echo "<td class='$claseComponente selda seldaVacia' id='".$fila."_".$columna."'><p></p></td>";
                    }
                }

            echo "</tr>";
        }

        echo "</table>";
    }
}

?>