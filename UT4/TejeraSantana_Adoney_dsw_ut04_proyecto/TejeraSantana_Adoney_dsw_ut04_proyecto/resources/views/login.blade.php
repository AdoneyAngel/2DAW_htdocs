<meta name="metaToken" content="{{ csrf_token() }}">

<div id="loginForm">
    <label>Usuario</label><input type="mail" id="usuario" placeholder="root@gmail.com" required>
    <label>Clave</label><input type="password" id="clave" placeholder="1234" required>

    <button onclick="login()">Enviar</button>
</div>

<script src="./js/funciones.js"></script>
