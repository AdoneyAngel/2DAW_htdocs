<style>
    header {
        margin-bottom: 25px;
        background: #dfdfdf;
        padding: 10px;
        border-radius: 5px
    }
    header a {
        text-decoration: none;
        color: blue;
        margin: 0 10px;
    }
</style>
<header>
    <a href="/">Menu</a>
    <a href="{{route("usuarios.index")}}">Usuarios</a>
    <a href="{{route("roles.index")}}">Roles</a>
    <a href="{{route("permisos.index")}}">Permisos</a>
</header>
