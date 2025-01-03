<meta name="metaToken" content="{{ csrf_token() }}">

<div id="loginForm">
    <label>Usuario</label><input type="mail" id="usuario" placeholder="Usuario" required>
    <label>Clave</label><input type="password" id="clave" placeholder="Clave" required>

    <button onclick="login()">Enviar</button>
</div>

<script src="./js/funciones.js"></script>
