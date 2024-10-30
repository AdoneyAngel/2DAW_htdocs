<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Seleccionar estilos</title>
    <style>

        body {
            background: {{$color}}
        }

    </style>
</head>
<body>

    <h1>Preferencias de estilo</h1>
    <form action="guardar_cookie" method="post">
        @csrf
        <input type="radio" name="color" id="" value="red"><label for="">Rojo</label><br>
        <input type="radio" name="color" id="" value="green"><label for="">Verde</label><br>
        <input type="radio" name="color" id="" value="blue"><label for="">Azul</label>
        <br><br>
        <button>Guardar estilo</button>
    </form>

</body>
</html>
