<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categorias</title>
</head>
<body>
    @include("header")

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categorias as $categoria)
                <tr>
                    <td>{{$categoria->nombre}}</td>
                    <td>{{$categoria->descripcion}}</td>
                    <td>
                        <a href="{{route("categorias.productos", $categoria->id)}}">Ver Productos</a>
                        <a href="{{route("categorias.edit", $categoria->id)}}">Editar</a>
                        <form style="display: inline" action="{{route("categorias.destroy", $categoria->id)}}" method="POST">
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
