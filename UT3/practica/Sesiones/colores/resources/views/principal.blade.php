<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal</title>
    <style>
        div {
            background: {{ $color }}
        }
    </style>
</head>
<body>
    <div>El color seleccionado es {{ $color }}</div>
    <form action="logout">
       <button>Cerrar sesión</button>
    </form>
</body>
</html>
