<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuario: {{$usuario->id}}</title>
</head>
<body>

    <h1>Nombre: {{$usuario->nombre}}</h1>
    <h1>Apellidos: {{$usuario->apellidos}}</h1>
    <h1>Mail: {{$usuario->mail}}</h1>
    <a href="/usuarios">Volver</a>

</body>
</html>
