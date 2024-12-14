<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roles</title>
    <style>
        label {
            background: #dfdfdf;
            border-radius: 5px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>Roles</h1>

    <a href="{{route("roles.create")}}">Crear nuevo rol</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
                <tr>
                    <td>{{$rol->id}}</td>
                    <td>{{$rol->nombre}}</td>
                    <td>
                        @foreach($rol->permisos as $permiso)
                            <label>{{$permiso->nombre}}</label>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{route("roles.edit", $rol)}}">Editar</a>
                        <button>Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
