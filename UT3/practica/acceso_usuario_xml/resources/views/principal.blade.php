<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Página principal</title>
</head>
<body>
    <h1>Usuarios</h1>
    <form action="info" method="post">
        @csrf

        <select name="user">
            @foreach ($usuarios as $usuario)
                <option value="{{$usuario}}">{{$usuario}}</option>
            @endforeach
        </select>
        <button>Mostrar información</button>
    </form>
    <a href="logout">Cerrar sesion</a>
</body>
</html>
