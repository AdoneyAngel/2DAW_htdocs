<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar: {{$usuario->id}}</title>
</head>
<body>

    <form action="/usuarios/{{$usuario->id}}" method="POST">
        @csrf
        @method("PUT")

        <input type="number" name="id" value="{{$usuario->id}}" style="display:none">

        <h1>Nombre</h1>
        <input type="text" name="nombre" placeholder="{{$usuario->nombre}}">

        <br>

        <h1>Apellidos</h1>
        <input type="text" name="apellidos" placeholder="{{$usuario->apellidos}}">

        <br>

        <h1>Mail</h1>
        <input type="mail" name="mail" placeholder="{{$usuario->mail}}">

        <br>
        <br>

        <button>Editar</button>

        <br>
        <br>

    </form>
    <a href="/usuarios">Cancelar</a>

</body>
</html>
