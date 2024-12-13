<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Crear usuarios</h1>
    <form action="{{route("usuarios.store")}}" method="POST">
        @csrf
        <h2>Nombre</h2>
        <input type="text" name="nombre">

        <h2>Apellidos</h2>
        <input type="text" name="apellidos">

        <h2>Correo Electrónico</h2>
        <input type="text" name="mail">

        <br>
        <button>Crear</button>
    </form>
</body>
</html>
