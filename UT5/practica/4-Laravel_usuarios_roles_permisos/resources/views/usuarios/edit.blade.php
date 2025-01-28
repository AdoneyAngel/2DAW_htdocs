@include('layouts.header')

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Editar Usuario: {{ $usuario->nombre }}</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Campo Nombre -->
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" required>
                </div>

                <!-- Campo Apellidos -->
                <div class="form-group col-md-6">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $usuario->apellidos }}" required>
                </div>

                <!-- Campo Usuario -->
                <div class="form-group col-md-6">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario->usuario }}" required>
                </div>

                <!-- Campo Contraseña -->
                <div class="form-group col-md-6">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese nueva contraseña (opcional)">
                </div>

                <!-- Campo Email -->
                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                </div>

                <!-- Campo Roles -->
                <div class="form-group col-md-6">
                    <label for="roles">Roles de Usuario:</label>
                    <select class="form-control" id="roles" name="roles[]" multiple>
                        @foreach ($listaRoles as $rol)
                        <option value="{{ $rol->id }}"
                            @if ($usuario->roles->contains('id', $rol->id)) selected @endif>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                    </select>
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
