@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestión de Roles</h1>
            <a href="{{ route('roles.create') }}" class="btn btn-outline-success">Crear Rol</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Permisos</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listaRoles as $rolUsuario)
                    <tr>
                        <td>{{ $rolUsuario->id }}</td>
                        <td>
                            <a href="{{ route('roles.show', $rolUsuario) }}" class="text-decoration-none">
                                {{ $rolUsuario->nombre }}
                            </a>
                        </td>
                        <td>
                            @foreach ($rolUsuario->permisos as $permiso)
                                <span class="badge bg-secondary">{{ $permiso->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="col-1 text-center">
                            <a href="{{ route('roles.edit', $rolUsuario) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                        <td class="col-1 text-center">
                            <form action="{{ route('roles.destroy', $rolUsuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este rol?');">
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
