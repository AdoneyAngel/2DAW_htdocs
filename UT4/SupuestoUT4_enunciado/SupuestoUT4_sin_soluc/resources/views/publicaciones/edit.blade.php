@include('layouts.header')

<body>
    @include('layouts.menu')
    <div class="container mt-4">
        <h1 class="mb-4">Editar Publicación: {{ $publicacion->Nombre }}</h1>

        <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $publicacion->Nombre }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $publicacion->Descripcion }}</textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="url">URL:</label>
                    <input type="text" class="form-control" id="url" name="url" value="{{ $publicacion->URL_Archivo }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="fecha">Fecha Publicación:</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ $publicacion->Fecha_Publicacion }}" required>

                </div>

                <div class="form-group col-md-6">
                    <label for="usuario">Usuario:</label>
                    <select class="form-control" id="usuario" name="usuario">
                        @foreach ($listaUsuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                @if ($listaUsuarios->contains('id', $publicacion->Usuario_ID)) selected @endif>
                                {{ $usuario->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('publicaciones.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
