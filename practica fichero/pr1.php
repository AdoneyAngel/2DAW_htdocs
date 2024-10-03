<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$rutaFicheros = $_SERVER["DOCUMENT_ROOT"] . "/ficheros/";

if (isset($_FILES["archivo"])) {
    $archivo = $_FILES["archivo"];

    echo $archivo["type"] . "<br>";
    echo $archivo["name"] . "<br>";
    echo $archivo["tmp_name"] . "<br>";
    echo ($archivo["size"]/1024/1024) . "MB <br>";


    echo $rutaFicheros;

    if (!is_dir($rutaFicheros)) {+
        mkdir($rutaFicheros);
    }

    move_uploaded_file($archivo["tmp_name"], $rutaFicheros.$archivo["name"]);
    
}

echo "<br>";
echo "<br>";

//Practica leyendo un archivo llamado prueba.txt
if (is_file($rutaFicheros)."/prueba.txt") {
    $rutaPrueba = $rutaFicheros."prueba.txt";

    $archivoAbierto = fopen($rutaPrueba, "r");

    //Caracter por caracter
    while (!feof($archivoAbierto)) {
        echo fread($archivoAbierto, 1);
    }

    echo "<br>";

    //Todo el contenido de una
    echo file_get_contents($rutaPrueba);

    echo "<br>";

    //Linea a linea

    while ($linea = fgets($archivoAbierto)) {
        if (feof($archivoAbierto)) {
            break;
        }

        echo $linea;
    }

    fclose($archivoAbierto);
}


?>

    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" >
        <button>Subir</button>
    </form>
</body>
</html>