@include("layouts.header")

<h1>Añadir Nuevas Categorías</h1>

<div id="añadirCategoriaForm">
    <label>Nombre Categoría: </label>
    <input type="text" id="nombre" placeholder="Nueva Categoría">

    <br><br>

    <label>Descripción Categoría: </label>
    <textarea id="descripcion" cols="30" rows="10" placeholder="Descripción de la nueva Categoría"></textarea>

    <br><br>

    <button onclick="añadirCategoria()">Añadir Categoría</button>
</div>
