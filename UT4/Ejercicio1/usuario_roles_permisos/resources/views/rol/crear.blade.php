<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear nuevo rol</title>
</head>
<body>
    @include("layouts.header")
    <h1>Crear nuevo rol</h1>

    <form action="{{route("roles.store")}}" method="POST">
        @csrf

        <h2>Nombre</h2>
        <input type="text" name="nombre">

        <br>

        <select name="permisos[]" multiple>
            @foreach ($permisos as $permiso)
                <option value="{{$permiso->id}}">{{$permiso->nombre}}</option>
            @endforeach
        </select>

        <button>Crear</button>
    </form>

    <a href="{{route("roles.index")}}">Volver</a>
</body>
</html>
