<h1>Editar Categoría</h1>

<div id="editarCategoriaForm">
    <label>Nombre Categoría: </label>
    <input type="text" id="nombre" value="{{$categoria->nombre}}">

    <br><br>

    <label>Descripción Categoría: </label>
    <textarea id="descripcion" cols="30" rows="10">{{$categoria->descripcion}}</textarea>

    <br><br>

    <button onclick="editarCategoriaForm({{$categoria->id}})">Editar Categoría</button>
</div>
