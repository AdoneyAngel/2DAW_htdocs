@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1>Publicación: {{ $publicacion->Nombre }}</h1>

        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="id">ID:</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ $publicacion->id }}"
                        readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ $publicacion->Nombre }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" readonly>{{ $publicacion->Descripcion }}</textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="url">URL:</label>
                    <input type="text" class="form-control" id="url" name="url"
                        value="{{ $publicacion->URL_Archivo }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="fecha">Fecha Publicación:</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha"
                        value="{{ $publicacion->Fecha_Publicacion }}" readonly>
                </div>
            </div>

            <br>

            <h1 class="mb-4">Usuario de la Publicación: </h1>
            <div class="row">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Foto</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$usuario->id}}</td>
                            <td>{{$usuario->Nombre}}</td>
                            <td>{{$usuario->Nombre_Usuario}}</td>
                            <td>{{$usuario->Correo_Electronico}}</td>
                            <td>{{$usuario->Foto_Perfil}}</td>
                            <td>{{$usuario->Fecha_Registro}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <br>

            <h1 class="mb-4">Comentarios de la publicación: </h1>
            <div class="row">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Publicación</th>
                            <th>Texto del Comentario</th>
                            <th>Fecha Comentario</th>
                            <th>Nombre de Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comentarios as $comentario)
                            <tr>
                                <td>{{$comentario->id}}</td>
                                <td>{{$publicacion->Nombre}}</td>
                                <td>{{$comentario->Texto_Comentario}}</td>
                                <td>{{$comentario->Fecha_Comentario}}</td>
                                <td>{{$comentario->usuario->Nombre_Usuario}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Botón Volver -->
            <div class="mt-4">
                <a href="{{ route('publicaciones.index') }}" class="btn btn-primary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
