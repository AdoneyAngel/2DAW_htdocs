@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Detalle del Usuario: {{ $usuario->Nombre }}</h1>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->Nombre }}" readonly>
            </div>

            <div class="form-group col-md-6">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario->Nombre_Usuario }}" readonly>
            </div>

            <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->Correo_Electronico }}" readonly>
            </div>

            <div class="form-group col-md-6">
                <label for="fecha">Fecha Registro:</label>
                <input type="text" class="form-control" id="fecha" name="fecha" value="{{ $usuario->Fecha_Registro }}" readonly>
            </div>

            <div class="form-group col-md-6">
                <label for="foto">Foto:</label>
                <input type="text" class="form-control" id="foto" name="foto" value="{{ $usuario->Foto_Perfil }}" readonly>
            </div>

        </div>

        <br>

        <h1 class="mb-4">Publicaciones: </h1>
        <div class="row">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Publicación</th>
                        <th>URL</th>
                        <th>Fecha Publicación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listaPublicaciones as $publicacion)
                        <tr>
                            <td>{{$publicacion->id}}</td>
                            <td>{{$publicacion->Nombre}}</td>
                            <td>{{$publicacion->URL_Archivo}}</td>
                            <td>{{$publicacion->Fecha_Publicacion}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>

        <h1 class="mb-4">Comentarios Realizados por el Usuario: </h1>
        <div class="row">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Publicación</th>
                        <th>Texto del Comentario</th>
                        <th>Fecha Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listaComentarios as $comentario)
                        <tr>
                            <td>{{$comentario->id}}</td>
                            <td>{{$comentario->Nombre}}</td>
                            <td>{{$comentario->Texto_Comentario}}</td>
                            <td>{{$comentario->Fecha_Comentario}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botón Volver -->
        <div class="mt-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @include('layouts.footer')
</body>
