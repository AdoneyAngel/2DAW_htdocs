@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Crear Publicación</h1>

        <form action="{{ route('publicaciones.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">

                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>

                    <!-- mensajes de error con plantillas BLADE -->
                    @error('descripcion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="url">URL:</label>
                    <input type="text" class="form-control" id="url" name="url" value="">

                    <!-- mensajes de error con plantillas BLADE -->
                    @error('url')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="fecha">Fecha Publicación:</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value=""
                        required>
                    @error('fecha')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="usuario">Usuario:</label>
                    <select class="form-control" id="usuario" name="usuario">
                        @foreach ($listaUsuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->Nombre }}</option>
                        @endforeach
                    </select>

                    @error('usuario')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Crear</button>
                <a href="{{ route('publicaciones.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
