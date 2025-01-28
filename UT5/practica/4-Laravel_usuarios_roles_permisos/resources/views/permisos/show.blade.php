@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1>Permiso: {{ $permiso->nombre }}</h1>

        <form>
            <div class="row">
                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $permiso->nombre }}" readonly>
                </div>
            </div>

            <!-- Botón Volver -->
            <div class="mt-4">
                <a href="{{ route('permisos.index') }}" class="btn btn-primary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>

