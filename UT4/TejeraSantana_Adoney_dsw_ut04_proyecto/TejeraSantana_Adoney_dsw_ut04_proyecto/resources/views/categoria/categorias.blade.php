@include("layouts.header")

<h1>Lista de Categorías</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
            <tr>
                <td>{{$categoria->nombre}}</td>
                <td>{{$categoria->descripcion}}</td>
                <td>
                    <button onclick="mostrarListaCategoriaProductos({{$categoria->id}})">Ver Productos</button>
                    <button onclick="mostrarEditarCategoria({{$categoria->id}})">Editar</button>
                    <button onclick="eliminarCategoria({{$categoria->id}})">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
