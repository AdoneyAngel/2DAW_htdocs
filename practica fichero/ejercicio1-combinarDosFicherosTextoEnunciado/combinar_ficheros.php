<?php

$archivo1;
$archivo2;

if (isset($_FILES["archivo1"]) && isset($_FILES["archivo2"])) {
    $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

    $archivo1 = $_FILES["archivo1"];
    $archivo2 = $_FILES["archivo2"];

    //Se comprueba si existe la carpeta de ficheros
    checkFilesDir();

    try {
        //Se mueve a la carpeta de archivos    
        $rutaArchivo1 = moveToFiles($archivo1["tmp_name"]);
        $rutaArchivo2 = moveToFiles($archivo2["tmp_name"]);

        $combinacion = combineFiles($rutaArchivo1, $rutaArchivo2);

        echo "Archivo combinado creado correctamente. <br> Resultado: " . $combinacion;
        
    } catch (Exception $e) {
        echo "Error: ".$e->getMessage();
    }
 
}

function combineFiles($rutaArchivo1, $rutaArchivo2) {
    if (empty($rutaArchivo1) || !isset($rutaArchivo1)) {
        throw new Exception("Falta el parámetro 'rutaArchivo1'");

    } else if (!is_file($rutaArchivo1)) {
        throw new Exception("No se ha encontrado el archivo en la ruta: $rutaArchivo1");
    }

    if (empty($rutaArchivo2) || !isset($rutaArchivo2)) {
        throw new Exception("Falta el parámetro 'rutaArchivo2'");

    } else if (!is_file($rutaArchivo2)) {
        throw new Exception("No se ha encontrado el archivo en la ruta: $rutaArchivo2");
    }

    $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

    $contenidoArchivo1 = file_get_contents($rutaFicheros.basename($rutaArchivo1), 1);
    $contenidoArchivo2 = file_get_contents($rutaFicheros.basename($rutaArchivo2), 1);

    $contenidoCombinado = $contenidoArchivo1 . $contenidoArchivo2;

    $nuevoArchivo = fopen($rutaFicheros."combinacion.txt", "w");
    
    fwrite($nuevoArchivo, $contenidoCombinado);

    fclose($nuevoArchivo);

    return $contenidoCombinado; 

}

function moveToFiles($rutaArchivo) {
    if (!isset($rutaArchivo)) {
        throw new ErrorException("Falta 1 parámetro (rutaArchivo)");

    } else if (!is_file($rutaArchivo)) {
        throw new Exception("No se ha encontrado el archivo en la ruta: $rutaArchivo");
        
    } else {
        $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

        move_uploaded_file($rutaArchivo, $rutaFicheros.basename($rutaArchivo));

        return $rutaFicheros.basename($rutaArchivo);
    }

}

function checkFilesDir () {
    $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

    if (!is_dir($rutaFicheros)) {
        mkdir($rutaFicheros);
    }
}

?>