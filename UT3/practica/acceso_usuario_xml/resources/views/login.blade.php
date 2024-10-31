<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <p style="color:red">{{isset($message) ? $message : ""}}</p>
    <h1>Login de Usuario</h1>
    <form action="login" method="post">
        @csrf

        <br>

        <h2>Usuario</h2>
        <input type="text" name="user" required>

        <br>

        <h2>Password</h2>
        <input type="password" name="pass" required>

        <br><br>

        <button>Iniciar sesion</button>

    </form>
</body>
</html>
