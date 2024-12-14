<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Permisos</h1>

    <a href="{{route("permisos.create")}}">Crear nuevo permiso</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Permiso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permisos as $permiso)
                <tr>
                    <td>{{ $permiso->id }}</td>
                    <td>{{ $permiso->nombre }}</td>
                    <td>
                        <a href="{{route("permisos.edit", $permiso)}}">Editar</a>
                        <form action="{{route("permisos.destroy", $permiso)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button>Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
