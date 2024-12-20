<h1>Editar Producto</h1>

<div id="editarProductoForm">
    <label>Nombre Producto: </label>
    <input type="text" id="nombre" placeholder="Nuevo Producto" value="{{$producto->nombre}}">

    <br><br>

    <label>Descripción Producto: </label>
    <textarea id="descripcion" cols="30" rows="10" placeholder="Descripción del producto">{{$producto->descripcion}}</textarea>

    <br><br>

    <label>Stock: </label>
    <input placeholder="Cantidad disponible" id="stock" type="number" min="0" value="{{$producto->stock}}">

    <br><br>

    <label>Categoría del Producto: </label>
    <select id="categoria">
        @foreach ($categorias as $categoria)
            {{-- Se busca si está dentro del producto --}}
            @if ($categoria->id == $producto->categoria)
                <option value="{{$categoria->id}}" selected>{{$categoria->nombre}}</option>

            @else
                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>

            @endif
        @endforeach
    </select>

    <br><br>

    <button onclick="editarProducto({{$producto->id}})">Editar Producto</button>
</div>
