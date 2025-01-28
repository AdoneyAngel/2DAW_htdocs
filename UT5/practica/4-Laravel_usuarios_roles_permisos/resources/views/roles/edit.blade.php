@include('layouts.header')

<body>
    @include('layouts.menu')
    <div class="container mt-4">
        <h1 class="mb-4">Editar Rol: {{ $rol->nombre }}</h1>

        <!-- Formulario para editar el rol -->
        <form action="{{ route('roles.update', $rol->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $rol->nombre }}">
                </div>

                <!-- Campo Permisos -->
                <div class="form-group col-md-6">
                    <label for="permisos">Permisos:</label>
                    <select class="form-control" id="permisos" name="permisos[]" multiple>
                        @foreach ($listaPermisos as $permiso)
                            <option value="{{ $permiso->id }}"
                                @if ($rol->permisos->contains('id', $permiso->id)) selected @endif>
                                {{ $permiso->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
