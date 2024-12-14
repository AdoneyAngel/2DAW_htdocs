<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Rol</title>
</head>
<body>
    <h1>Editar permiso</h1>

    <form action="{{route("roles.update", $rol->id)}}" method="POST">
        @csrf
        @method("PUT")

        <h2>Rol</h2>
        <input type="text" name="nombre" value="{{$rol->nombre}}" placeholder="{{$rol->nombre}}">

        <br>
        <h2>Permisos:</h2>

        <select name="permisos[]" multiple>
            @foreach($permisos as $permiso)
                {{$tienePermiso = false}}

                @foreach ($rol->permisos as $permisoDeRol)
                    @if ($permisoDeRol->id == $permiso->id)
                        {{$tienePermiso = true}}
                    @endif
                @endforeach

                @if ($tienePermiso)
                    <option selected value="{{$permiso->id}}">{{$permiso->nombre}}</option>

                    @else
                        <option value="{{$permiso->id}}">{{$permiso->nombre}}</option>

                @endif
            @endforeach
        </select>

        <br><br>

        <button>Guardar</button>

    </form>
</body>
</html>
