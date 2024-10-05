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
        <input type="number" name="inFila" id="inFila">
        <h2>Columna inicial</h2>
        <input type="number" name="inCol" id="inCol">
        <h2>Fila final</h2>
        <input type="number" name="finFila" id="finFila">
        <h2>Columna final</h2>
        <input type="number" name="finCol" id="finCol">

        <button>Mover</button>
    </form>
</body>
</html>
<script>

    const piezas = document.querySelectorAll("td.pieza")
    const seldas = document.querySelectorAll("td.seldaVacia");

    const inputInFila = document.getElementById("inFila")
    const inputInCol = document.getElementById("inCol")
    const inputFinFila = document.getElementById("finFila")
    const inputFinCol = document.getElementById("finCol")

    let inFila = null
    let inCol = null
    let finFila = null
    let finCol = null

    seldas.forEach(seldaActual => {
        seldaActual.addEventListener("click", () => {
            if (inFila !== null && inCol !== null) {
                const fila = seldaActual.id.split("_")[0] 
                const columna = seldaActual.id.split("_")[1] 

                finFila = fila
                finCol = columna

                inputFinFila.value = fila
                inputFinCol.value = columna
            }

            seleccionarSeldas()
        })
    })

    piezas.forEach(piezaActual => {
        piezaActual.addEventListener("click", () => {
            const fila = piezaActual.id.split("_")[0] 
            const columna = piezaActual.id.split("_")[1] 

            if (!inFila || !inCol) {
                inFila = fila
                inCol = columna 

                inputInFila.value = fila
                inputInCol.value = columna

            } else if (finFila || finCol){
                inFila = fila
                inCol = columna 
                finFila = null
                finCol = null

                inputInFila.value = fila
                inputInCol.value = columna
                inputFinFila.value = null
                inputFinCol.value = null

            } else if (inFila || inCol) {
                finFila = fila
                finCol = columna

                inputFinFila.value = finFila
                inputFinCol.value = finCol

            }

            seleccionarSeldas()
        })
    })

    function seleccionarSeldas() {
        seldas.forEach(seldaActual => {
            seldaActual.className = seldaActual.className.replace("inicial", "")
            seldaActual.className = seldaActual.className.replace("final", "")

        })
        piezas.forEach(piezaActual => {
            piezaActual.className = piezaActual.className.replace("inicial", "")
            piezaActual.className = piezaActual.className.replace("final", "")

        })

        if (inFila || inCol) {
            const seldaInicial = document.getElementById(inFila + "_" + inCol)
            seldaInicial.className = seldaInicial.className + " inicial"
            
        }

        if (finFila || finCol) {
            const seldaInicial = document.getElementById(finFila + "_" + finCol)
            seldaInicial.className = seldaInicial.className + " final"
        }
    }

</script>