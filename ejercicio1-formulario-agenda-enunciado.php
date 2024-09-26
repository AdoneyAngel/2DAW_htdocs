<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>

<?php
/*Debes programar una aplicación para mantener una pequeña agenda en una única página web programada en PHP.

La agenda almacenará únicamente dos datos de cada persona: su nombre y un número de teléfono. Además, no podrá haber nombres repetidos en la agenda.

En la parte superior de la página web se mostrará el contenido de la agenda. En la parte inferior debe figurar un sencillo formulario con dos cuadros de texto, uno para el nombre y otro para el número de teléfono.

Cada vez que se envíe el formulario:

Si el nombre está vacío, se mostrará una advertencia.
Si el nombre que se introdujo no existe en la agenda, y el número de teléfono no está vacío, se añadirá a la agenda.
Si el nombre que se introdujo ya existe en la agenda y se indica un número de teléfono, se sustituirá el número de teléfono anterior.
Si el nombre que se introdujo ya existe en la agenda y no se indica número de teléfono, se eliminará de la agenda la entrada correspondiente a ese nombre.
*/

$agendaPrev = [];
$agendaPrevSTr = "";

if (isset($_POST["prev"])) {
    $agendaPrev = toArray($_POST["prev"]);
    $agendaPrevSTr = toString($agendaPrev);
}

if (isset($_POST["name"])) {
    $nombre = $_POST["name"];

    if (strlen($nombre) === 0) {
        echo "<h1 style='color:red'>FALTA EL NOMBRE DEL CONTACTO</h1>";

    } else {
        if ($_POST["phone"]) {
            $telefono = $_POST["phone"];

            $agendaPrev[$nombre] = $telefono;
            
            $agendaPrevSTr = toString($agendaPrev);

        } else {
            if (isset($agendaPrev[$nombre])) {
                unset($agendaPrev[$nombre]);
                $agendaPrevSTr = toString($agendaPrev);
            }
        }       
    }

} else {
    echo "<h1 style='color:red'>FALTA EL NOMBRE DEL CONTACTO</h1>";
}

function toString($array) {
    $string = "";

    foreach ($array as $contacto => $telefono) {
        $string = $string."|$contacto.$telefono";
    }

    return $string;
}

function toArray($string) {
    $contactos = explode("|", $string);
    unset($contactos[0]);
    
    $array = [];

    foreach ($contactos as $contacto) {
        $datos = explode(".", $contacto);

        $array[$datos[0]] = $datos[1];
    }

    return $array;
}

//Imprimir contactos anteriores

if (!empty($agendaPrev)) {
    echo "<h1>Agenda:</h1>";

    echo "<ul>";

        foreach ($agendaPrev as $contacto => $tel) {
            echo "<li>$contacto: $tel</li>";
        }
        
    echo "</ul>";
}

?>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
        <h1>Agregar contacto</h1>
        <input type="text" placeholder="nombre" name="name">
        <input type="text" placeholder="Teléfono" name="phone">
        <input type="text" name="prev" value="<?php echo $agendaPrevSTr;?>" hidden>
        <button>Guardar</button>
    </form>
</body>
</html>