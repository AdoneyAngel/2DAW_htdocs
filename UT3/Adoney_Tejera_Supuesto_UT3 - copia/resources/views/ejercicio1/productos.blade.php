<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
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
                            echo $productoActual["precio"];
                        echo "</td>";

                        echo "<td>";
                            echo $productoActual["categoria"];
                        echo "</td>";

                        echo "<td>";
                            echo "<a href='/productos/".$productoActual['id']."'>Ver detalles</a>";
                        echo "</td>";

                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
