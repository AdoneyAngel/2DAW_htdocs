<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{csrf_token()}}">
    <title>Tejera Santana Adoney Actividad UT3</title>
</head>
<body>
    {{
        view("Cabecera")
    }}

    <div id="login" style="display: none">
        <h2>Usuario</h2>
        <input id="usuarioInput" type="text" placeholder="Nombre@usuario.com">

        <h2>Clave</h2>
        <input id="claveInput" type="password" placeholder="Contraseña">

        <button onclick="login()">Iniciar Sesión</button>
    </div>

    <script src="/js/cargarDatos.js"></script>
</body>
</html>
