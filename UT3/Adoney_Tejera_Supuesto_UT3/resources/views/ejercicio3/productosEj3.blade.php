<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Menú:</h1>
    <header style="border-bottom:1px solid black">Opciones: <a href="#">Ver Productos</a> </header>
    <h2>Filtrar Productos</h2>
    <p>No hecho</p>

    <h2>Listado de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Categoría</th>
                <th>Fecha de lanzamiento</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($productoI = 0; $productoI<count($productos); $productoI++){
                    echo "<tr>";

                        $productoActual = $productos[$productoI];

                        echo "<td>";
                            echo $productoActual["id"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["nombre"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["detalles"]["descripcion"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["detalles"]["marca"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["categoria"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["categoria"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["detalles"]["fecha_lanzamiento"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["precio"];
                        echo "</td>";

                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>

</body>
</html>
