<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actividad UT4 Adoney Tejera Santana</title>
</head>
<body>
    <form action="{{route("login")}}" method="POST">
        @csrf
        <input type="mail" name="usuario">
        <input type="password" name="clave">
        <button>Login</button>
    </form>
</body>
</html>
