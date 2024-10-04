<?php

require_once("./controller/Controller.php");

$controller = new Controller();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajedrez</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <?php
        $controller->tablaHtml();
    ?>

    <form action="index.php" method="post">
        <h2>Fila inicial</h2>
        <input type="number" name="inFila">
        <h2>Columna inicial</h2>
        <input type="number" name="inCol">
        <h2>Fila final</h2>
        <input type="number" name="finFila">
        <h2>Columna final</h2>
        <input type="number" name="finCol">

        <button>Mover</button>
    </form>
</body>
</html>