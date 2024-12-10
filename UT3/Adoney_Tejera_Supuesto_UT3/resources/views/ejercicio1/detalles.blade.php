<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalles</title>
</head>
<body>

    <h1>{{isset($error) ? $error : ""}}</h1>
    <h1>{{isset($producto["id"]) ? "Detalles del Producto con Id = ".$producto["id"] : ""}}</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Fecha Lanzamiento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php

            if ($producto) {
                echo "<td>";
                    echo $producto["id"];
                echo "</td>";

                echo "<td>";
                    echo $producto["descripcion"];
                echo "</td>";

                echo "<td>";
                    echo $producto["marca"];
                echo "</td>";

                echo "<td>";
                    echo $producto["descripcion"];
                echo "</td>";
            }

        ?>
        </tr>
    </tbody>
</table>
<a href="/productos">Volver</a>

</body>
</html>
