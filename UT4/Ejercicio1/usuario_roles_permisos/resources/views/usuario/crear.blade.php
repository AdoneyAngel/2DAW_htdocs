<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo usuario</title>
</head>
<body>
    @include("layouts.header")
    <h1>Crear nuevo usuario</h1>

    <form action="{{route("usuarios.store")}}" method="POST">
        @csrf

        <h2>Nombre</h2>
        <input type="text" name="nombre" required>

        <br>

        <h2>Apellidos</h2>
        <input type="text" name="apellidos" required>

        <br>

        <h2>Emai</h2>
        <input type="mail" name="email" required>

        <br>

        <h2>Password</h2>
        <input type="password" name="password" required>

        <br>

        <select name="roles[]" multiple>
            <?php

            foreach ($roles as $rol) {
                echo "<option value='$rol->id'>$rol->nombre</option>";
            }

            ?>
        </select>

        <br><br>

        <button>Crear</button>
    </form>

</body>
</html>
