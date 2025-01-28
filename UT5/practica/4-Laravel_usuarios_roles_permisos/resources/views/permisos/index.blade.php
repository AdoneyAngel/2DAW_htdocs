@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestión de Permisos</h1>
            <a href="{{ route('permisos.create') }}" class="btn btn-outline-success">Crear Permiso</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listaPermisos as $permiso)
                    <tr>
                        <td>{{ $permiso->id }}</td>
                        <td>
                            <a href="{{ route('permisos.show', $permiso->id) }}" class="text-decoration-none">
                                {{ $permiso->nombre }}
                            </a>
                        </td>
                        <td class="col-1 text-center">
                            <a href="{{ route('permisos.edit', $permiso) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                        <td class="col-1 text-center">
                            <form action="{{ route('permisos.destroy', $permiso) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar este permiso?');">
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
