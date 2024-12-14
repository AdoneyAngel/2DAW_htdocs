<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar permiso</title>
</head>
<body>
    @include("layouts.header")

    <h1>Editar permiso</h1>

    <form action="{{route("permisos.update", $permiso->id)}}" method="POST">
        @csrf
        @method("PUT")

        <h2>Nombre</h2>
        <input type="text" name="nombre" placeholder="{{$permiso->nombre}}">
        <button>Guardar</button>
    </form>

    <a href="{{route("permisos.index")}}">Volver</a>

</body>
</html>
