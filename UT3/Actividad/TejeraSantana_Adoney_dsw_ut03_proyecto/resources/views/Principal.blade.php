<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{csrf_token()}}">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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

    <div id="lista_libros">
        <h1>Libros</h1>
        <table class="table table-striped table-hover table-borderless table-primary align-middle table-light">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Escritoresz</th>
                    <th>Género</th>
                    <th>Páginas</th>
                    <th>Imagen</th>
                    <th>Unidades</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div id="lista_libros_genero">
        <h1>Libros</h1>
        <table class="table table-striped table-hover table-borderless table-primary align-middle table-light">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Escritoresz</th>
                    <th>Género</th>
                    <th>Páginas</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div id="lista_carrito">
        <h1>Carrito de Libros</h1>
        <p id="carritoArticulos"></p>
        <p id="carritoUnidades"></p>
        <table class="table table-striped table-hover table-borderless table-primary align-middle table-light">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Escritoresz</th>
                    <th>Género</th>
                    <th>Páginas</th>
                    <th>Imagen</th>
                    <th>Unidades</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <a href="/procesar_pedido">Realizar pedido</a>
    </div>

    <div id="lista_generos">
        <ul>

        </ul>
    </div>
    <script src="/js/cargarDatos.js"></script>
</body>
</html>
