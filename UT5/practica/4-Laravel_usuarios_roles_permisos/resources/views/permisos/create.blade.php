@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Crear Permiso</h1>

        <!-- Formulario para crear un nuevo permiso -->
        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="row">
                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">

                    <!-- Mensajes de error con plantillas Blade -->
                    @error('nombre')
                        <small class="text-danger">{{ $resultado }}</small>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Crear</button>
                <a href="{{ route('permisos.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
