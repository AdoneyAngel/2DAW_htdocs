<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear permiso</title>
</head>
<body>
    @include("layouts.header")
    <h1>Crear permiso</h1>

    <form action="{{route("permisos.store")}}" method="POST">
        @csrf

        <h2>Nombre</h2>
        <input type="text" name="nombre">
        <button>Crear</button>

    </form>

    <a href="{{route("permisos.index")}}">Volver</a>
</body>
</html>
