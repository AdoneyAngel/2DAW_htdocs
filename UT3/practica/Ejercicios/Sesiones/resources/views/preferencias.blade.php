<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="sesion" method="post">
        @csrf
        <label for="">Idioma:</label>
        <select name="idioma">
            @foreach ($idiomas as $idioma)
                <option value="{{$idioma->name}}">{{$idioma->value}}</option>
            @endforeach
        </select>
        <select name="publico">
            <option value="1">Si</option>
            <option value="0">No</option>
        </select>
        <select name="zonaHoraria">
            @foreach($zonasHorarias as $zonaActual)
                <option value="{{$zonaActual->name}}">{{$zonaActual->value}}</option>
            @endforeach
        </select>

        <button>Enviar</button>
    </form>
</body>
</html>
