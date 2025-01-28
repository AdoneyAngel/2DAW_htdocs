@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1>Rol: {{ $rol->nombre }}</h1>

        <form>
            <div class="row">
                <!-- Campo ID -->
                <div class="form-group col-md-6">
                    <label for="id">ID:</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ $rol->id }}" readonly>
                </div>

                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $rol->nombre }}" readonly>
                </div>

                <!-- Campo Permisos -->
                <div class="form-group col-md-6">
                    <label for="permisos">Permisos:</label>
                    <select class="form-control" id="permisos" name="permisos[]" multiple readonly>
                        @foreach ($rol->permisos as $permiso)
                            <option value="{{ $permiso->id }}">{{ $permiso->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botón Volver -->
            <div class="mt-4">
                <a href="{{ route('roles.index') }}" class="btn btn-primary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
