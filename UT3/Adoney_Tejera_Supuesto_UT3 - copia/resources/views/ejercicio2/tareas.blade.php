<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tareas</title>
</head>
<body>
    <h1>{{count($tareas) ? "Lista de Tareas Pendientes" : "No existen tareas pendientes"}}</h1>

    <h2>Agregar Nueva Tarea</h2>
    <label>Nombre de la tarea</label><input id="nombre" type="text">
    <br>
    <label>Descripción de la tarea</label><input id="descripcion" type="text">
    <button onclick="agregarTarea()">Agregar Tarea</button>

    <script>


        async function agregarTarea() {
            const nombreInput = document.getElementById("nombre")
            const descripcionInput = document.getElementById("descripcion")

            const enviado = await fetch("/tareas/agregar")

            if (enviado) {
                alert("si")

            } else {
                alert("no")
            }
        }


    </script>
</body>
</html>
