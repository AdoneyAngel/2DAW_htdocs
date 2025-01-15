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
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Fecha_Registro</th>
                    <th>Foto</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listaUsuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>
                            <a href="{{ route('usuarios.show', $usuario) }}" class="text-decoration-none">
                                {{ $usuario->Nombre }}
                            </a>
                        </td>

                        <td>{{ $usuario->Nombre_Usuario }}</td>
                        <td>{{ $usuario->Correo_Electronico }}</td>
                        <td>{{ $usuario->Fecha_Registro }}</td>
                        <td>{{ $usuario->Foto_Perfil }}</td>

                        <td class="col-1 text-center">
                            <a href="{{ route('usuarios.edit',  $usuario) }}" class="btn btn-primary btn-sm">
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
