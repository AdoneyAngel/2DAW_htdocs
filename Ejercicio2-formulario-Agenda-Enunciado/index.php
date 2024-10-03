<?php

require_once "./controller/Controller.php";

$controller = new Controller();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>
    <h1>Agenda</h1>
    <ul>

    </ul>

    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
        <h2>Formulario</h2>
        <input type="text" name="nombre">
        <input type="text" name="telefono">
        <input type="text" name="agendaString" value="<?php echo $controller->getAgendaString()?>" hidden>

        <input type="submit" value="Insertar" name="insertar">
        <input type="submit" value="Editar" name="editar">
        <input type="submit" value="Borrar" name="borrar">
    </form>
</body>
</html>