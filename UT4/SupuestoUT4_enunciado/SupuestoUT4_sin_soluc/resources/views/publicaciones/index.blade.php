@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Gestión de Publicaciones</h1>
            <a href="{{ route('publicaciones.create') }}" class="btn btn-outline-success">Crear Publicación</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>URL</th>
                    <th>Fecha Publicación</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listaPublicaciones as $publicacion)
                    <tr>
                        <td>{{ $publicacion->id }}</td>
                        <td>
                            <a href="{{ route('publicaciones.show', $publicacion) }}" class="text-decoration-none">
                                {{ $publicacion->Nombre }}
                            </a>
                        </td>
                        <td>
                            {{ $publicacion->Descripcion }}
                        </td>
                        <td>
                            {{ $publicacion->URL_Archivo }}
                        </td>
                        <td>
                            {{ $publicacion->Fecha_Publicacion }}
                        </td>
                        <td class="col-1 text-center">
                            <a href="{{ route('publicaciones.edit', $publicacion) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                        <td class="col-1 text-center">
                            <form action="{{ route('publicaciones.destroy', $publicacion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
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
