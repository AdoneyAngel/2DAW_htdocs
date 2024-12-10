<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Mail</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $csrfToken = csrf_field() ?>
            <?php $deleteMethod = method_field("DELETE") ?>
            <?php

            foreach ($usuarios as $usuario) {
                echo "<tr>";
                    echo "<td>$usuario->id</td>";
                    echo "<td>$usuario->nombre</td>";
                    echo "<td>$usuario->apellidos</td>";
                    echo "<td>$usuario->mail</td>";
                    echo "<td>
                            <a href='/usuarios/$usuario->id'>Detalles</a>
                            <a href='/usuarios/$usuario->id/edit'>Editar</a>
                            <form action='/usuarios/$usuario->id' method='POST'>
                                $csrfToken
                                $deleteMethod
                                <button>Eliminar</button>
                            </form>

                        </td>";
                echo "</tr>";
            }

            ?>
        </tbody>
    </table>

</body>
</html>
