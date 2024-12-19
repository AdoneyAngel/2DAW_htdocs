<h1>Carrito de la Compra</h1>
<br>

@if (!count($carrito))
    <p>Todavía no tiene productos</p>
@else
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Unidades</th>
            <th>Acciones</th>
            <th>Carrito</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carrito as $productoCarrito)
            <tr id="producto_{{$productoCarrito->producto()->first()->id}}">
                <td>{{$productoCarrito->producto()->first()->id}}</td>
                <td>{{$productoCarrito->producto()->first()->nombre}}</td>
                <td>{{$productoCarrito->producto()->first()->descripcion}}</td>
                <td>{{$productoCarrito->unidades}}</td>
                <td>
                    <button onclick="eliminarProductoCarrito({{$productoCarrito->producto()->first()->id}})">Eliminar Producto</button>
                </td>
                <td>
                    <input id="añadirProductoInput" type="number" min="1">
                    <button onclick="añadirProductoCarrito({{$productoCarrito->producto()->first()->id}})" id="añadirProductoBtn">Añadir</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="#" onclick="realizarPedido()">Realizar pedido</a>

@endif
