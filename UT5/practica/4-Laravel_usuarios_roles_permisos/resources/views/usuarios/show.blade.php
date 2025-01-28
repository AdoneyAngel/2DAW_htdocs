@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Detalle del Usuario: {{ $usuario->nombre }}</h1>

        <div class="row">
            <!-- Campo Nombre -->
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" readonly>
            </div>

            <!-- Campo Apellidos -->
            <div class="form-group col-md-6">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $usuario->apellidos }}" readonly>
            </div>

            <!-- Campo Usuario -->
            <div class="form-group col-md-6">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario->usuario }}" readonly>
            </div>

            <!-- Campo Contraseña -->
            <div class="form-group col-md-6">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ $usuario->password }}" readonly>
            </div>

            <!-- Campo Email -->
            <div class="form-group col-md-6">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" readonly>
            </div>

            <!-- Campo Roles -->
            <div class="form-group col-md-6">
                <label for="roles">Roles de Usuario:</label>
                <ul class="list-group">
                    @foreach ($usuario->roles as $rol)
                        <li class="list-group-item">{{ $rol->nombre }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="mt-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @include('layouts.footer')
</body>
