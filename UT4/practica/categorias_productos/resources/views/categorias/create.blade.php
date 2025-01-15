<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear categoria</title>
</head>
<body>
    @isset($error)
        <p style="color:red">{{$error}}</p>
    @endisset
    <form action="{{route("categorias.store")}}" method="POST">
        @csrf
        <h1>Crear Categoria</h1>

        <p>Nombre</p>
        @error("nombre")
            <label>El nombre es requerido</label>
        @enderror
        <input type="text" name="nombre">

        <p>Descripcion</p>
        @error("descripcion")
            <label>La descripcion es requerida</label>
        @enderror
        <textarea name="descripcion" cols="30" rows="10"></textarea>
        <button>Crear</button>
    </form>
</body>
</html>
