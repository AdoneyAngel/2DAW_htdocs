<h1>Productos</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Acciones</th>
            <th>Carrito</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr id="producto_{{$producto->id}}">
                <td>{{$producto->id}}</td>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->descripcion}}</td>
                <td>{{$producto->stock}}</td>
                <td>
                    <button onclick="eliminarProducto({{$producto->id}})">Eliminar Producto</button>
                </td>
                <td>
                    <input id="añadirProductoInput" type="number" min="1">
                    <button onclick="añadirProductoCarrito({{$producto->id}})" id="añadirProductoBtn">Añadir</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
