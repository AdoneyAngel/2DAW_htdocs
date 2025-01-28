@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestión de Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="btn btn-outline-success">Crear Usuario</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Permisos</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listaUsuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="text-decoration-none">
                                {{ $usuario->nombre }}
                            </a>
                        </td>
                        <td>{{ $usuario->apellidos }}</td>
                        <td>{{ $usuario->usuario }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            @if ($usuario->roles->isNotEmpty())
                                @foreach ($usuario->roles as $rol)
                                    <span class="badge bg-info text-dark">{{ $rol->nombre }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin roles</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $permisos = $usuario->roles->flatMap(fn($rol) => $rol->permisos)->unique('id');
                            @endphp
                            @if ($permisos->isNotEmpty())
                                @foreach ($permisos as $permiso)
                                    <span class="badge bg-secondary">{{ $permiso->nombre }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin permisos</span>
                            @endif
                        </td>
                        <td class="col-1 text-center">
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                        <td class="col-1 text-center">
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('layouts.footer')
</body>
