<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>
<h3>Usuario</h3>
<input type="text" placeholder="Introduce el nombre de usuario" id="userInput">

<h3>Contraseña</h3>
<input type="text" placeholder="Clave" id="passInput">

<br><br>

<button onclick="login()">Login</button>

<script>

async function login() {
    const userInput = document.getElementById("userInput")
    const passInput = document.getElementById("passInput")
    const sessionToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    if (userInput.value.length && passInput.value.length) {
        const rutaLogin = "login"

        const loginResponse = await fetch(rutaLogin, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": sessionToken,
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({user: userInput.value, password: passInput.value})
        });

        const loginResponseJson = await loginResponse.json()

        if (loginResponseJson.login == true) {
            window.location.href = loginResponseJson.redirect

        } else {
            alert("Usuario incorrecto")
        }

    } else {
        alert("Rellene los campos")
    }
}

</script>

</body>
</html>
