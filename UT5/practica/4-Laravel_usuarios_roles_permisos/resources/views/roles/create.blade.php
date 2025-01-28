@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Crear Rol</h1>

        <!-- Formulario para crear un nuevo rol -->
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">

                    <!-- mensajes de error con plantillas BLADE -->
                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="permisos">Permisos:</label>
                    <select class="form-control" id="permisos" name="permisos[]" multiple>
                        @foreach ($listaPermisos as $permiso)
                            <option value="{{ $permiso->id }}">{{ $permiso->nombre }}</option>
                        @endforeach
                    </select>

                    @error('permisos')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Crear</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
