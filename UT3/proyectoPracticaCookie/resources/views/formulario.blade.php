<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        *{
            font-size: {{ $fuente."px" }}
        }

    </style>
</head>
<body>
    <h1>Cambiar fuente</h1>
    <form action="fuente" method="POST">
        @csrf
        <input type="number" name="fuente" required>
        <button>Cambar</button>
    </form>
</body>
</html>
