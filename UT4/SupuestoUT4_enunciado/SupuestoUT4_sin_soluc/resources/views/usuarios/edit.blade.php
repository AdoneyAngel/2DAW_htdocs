@include('layouts.header')

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Editar Usuario: {{ $usuario->Nombre }}</h1>

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->Nombre }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="apellidos">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario->Nombre_Usuario }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="Contraseña">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ $usuario->Contraseña }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->Correo_Electronico }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="foto">Ruta Foto:</label>
                    <input type="text" class="form-control" id="foto" name="foto" value="{{ $usuario->Foto_Perfil }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="fecha">Fecha registro:</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ $usuario->Fecha_Registro }}"required>
                    @error('fecha')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
