@include('layouts.header')

<body>
    @include('layouts.menu')
    <div class="container mt-4">
        <h1 class="mb-4">Editar Permiso: {{ $permiso->nombre }}</h1>

        <!-- Formulario para editar el permiso -->
        <form action="{{ route('permisos.update', $permiso->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ $permiso->nombre }}">
                </div>
                <!-- Mensajes de error con plantillas Blade -->
                @error('nombre')
                    <small class="text-danger">{{ $resultado }}</small>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('permisos.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
