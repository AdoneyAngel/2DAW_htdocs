<h1>Añadir Nuevos Productos</h1>

<div id="añadirProductoForm">
    <label>Nombre Producto: </label>
    <input type="text" id="nombre" placeholder="Nuevo Producto">

    <br><br>

    <label>Descripción Producto: </label>
    <textarea id="descripcion" cols="30" rows="10" placeholder="Descripción del  nuevo producto"></textarea>

    <br><br>

    <label>Stock: </label>
    <input placeholder="Cantidad disponible" id="stock" type="number" min="0">

    <br><br>

    <label>Categoría del Producto: </label>
    <select id="categoria">
        @foreach ($categorias as $categoria)
            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
        @endforeach
    </select>

    <br><br>

    <button onclick="añadirProducto()">Añadir Producto</button>
</div>
