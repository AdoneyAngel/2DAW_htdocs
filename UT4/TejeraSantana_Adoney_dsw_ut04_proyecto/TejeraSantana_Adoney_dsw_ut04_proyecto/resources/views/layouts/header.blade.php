<meta name="metaToken" content="{{ csrf_token() }}">

<style>
    header {
        padding: 5px;
        border-bottom: 2px solid black;
    }
</style>

<header id="header">

<nav>
    <label id="usuarioLabel">Usuario</label>
    <a href="#" onclick="mostrarAñadirCategoria()">Añadir Categorías</a>
    <a href="#" onclick="mostrarListaCategorias()">Listar Categorías</a>
    <a href="#" onclick="mostrarAñadirProducto()">Añadir Productos</a>
    <a href="#" onclick="mostrarCarrito()">Carrito</a>
    <a href="#" onclick="logout()">Cerrar sesión</a>
</nav>

</header>

<script>
    //Validar que ha iniciado sesion

    async function isLogged() {
        const response = await fetch("/isLogged")
        const responseJson = await response.json()

        if (responseJson.respuesta) {
            nombreUsuario = responseJson.usuario
            usuarioLabel.innerHTML = "Usuario: "+nombreUsuario

        } else if (responseJson.error.length > 0) {
            alert("Error al verificar la sesión: "+responseJson.error)

        } else {
            window.location = "/loginView"
        }
    }

    isLogged()

</script>

<script src="../../js/funciones.js"></script>
