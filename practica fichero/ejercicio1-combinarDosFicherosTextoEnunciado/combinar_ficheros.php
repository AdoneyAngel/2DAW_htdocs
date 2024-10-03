<?php

$archivo1;
$archivo2;

if (isset($_FILES["archivo1"]) && isset($_FILES["archivo2"])) {
    $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

    $archivo1 = $_FILES["archivo1"];
    $archivo2 = $_FILES["archivo2"];

    //Se comprueba si existe la carpeta de ficheros
    checkFilesDir();

    move_uploaded_file($archivo1["tmp_name"], $rutaFicheros.$archivo1["name"]);
    move_uploaded_file($archivo2["tmp_name"], $rutaFicheros.$archivo2["name"]);

    $contenidoArchivo1 = file_get_contents($rutaFicheros.$archivo1["name"], 1);
    $contenidoArchivo2 = file_get_contents($rutaFicheros.$archivo2["name"], 1);

    $contenidoCombinado = $contenidoArchivo1 . $contenidoArchivo2;

    $nuevoArchivo = fopen($rutaFicheros."combinacion.txt", "w");
    
    fwrite($nuevoArchivo, $contenidoCombinado);

    fclose($nuevoArchivo);

    echo "Archivo combinado creado correctamente. <br> Resultado: " . $contenidoCombinado;
 
}

function checkFilesDir () {
    $rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

    if (!is_dir($rutaFicheros)) {
        mkdir($rutaFicheros);
    }
}

?>