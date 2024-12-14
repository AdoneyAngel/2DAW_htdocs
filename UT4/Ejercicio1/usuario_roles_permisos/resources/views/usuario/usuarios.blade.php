<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
    <style>
        label {
            background: #dfdfdf;
            border-radius: 5px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    @include("layouts.header")
    <a href="{{route("usuarios.create")}}">Nuevo usuario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Password</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
                $methodDelete = method_field("DELETE");
                $csrfToken = csrf_field();

                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                        echo "<td>" . $usuario['id'] . "</td>";
                        echo "<td>" . $usuario['nombre'] . "</td>";
                        echo "<td>" . $usuario['apellidos'] . "</td>";
                        echo "<td>" . $usuario['email'] . "</td>";
                        echo "<td>" . $usuario["password"] . "</td>";
                        //Se inserta cada rol del usuario
                        echo "<td>";
                        foreach ($usuario->roles as $rol) {
                            echo "<label>$rol->nombre</label>";
                        }
                        echo "</td>";
                        echo "<td>
                            <form action='".route("usuarios.destroy", $usuario)."' method='POST'>
                                $methodDelete
                                $csrfToken
                                <button>Eliminar</button>
                            </form>
                            <a href='".route("usuarios.edit", $usuario)."'>Editar</a>
                        </td>";
                    echo "</tr>";
                }
            ?>

        </tbody>
    </table>

    {{$usuarios->links()}}
</body>
</html>
