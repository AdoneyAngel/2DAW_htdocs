<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar usuario</title>
</head>
<body>
    @include("layouts.header")
    <h1>Editar usuario</h1>

    <form action="{{route("usuarios.update", $usuario->id)}}" method="POST">
        @csrf
        @method("PUT")
        <h2>Nombre</h2>
        <input type="text" name="nombre" value="{{$usuario->nombre}}" required>

        <br>

        <h2>Apellidos</h2>
        <input type="text" name="apellidos" value="{{$usuario->apellidos}}" required>

        <br>

        <h2>Email</h2>
        <input type="email" name="email" value="{{$usuario->email}}" required>

        <br>

        <h2>Password</h2>
        <input type="password" name="password" value="{{$usuario->password}}" required>

        <br><br>

        <select name="roles[]" multiple>
            <?php

            foreach ($roles as $rol) {
                echo "<option value='$rol->id'>$rol->nombre</option>";
            }

            ?>
        </select>

        <button>Guardar</button>
    </form>
</body>
</html>
