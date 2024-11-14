<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <title>Peliculas</title>
</head>
<body>
    <section class="contenido">

        <h2>Titulo</h2>
        <p id="titulo"></p>
        <h2>Fecha</h2>
        <p id="fecha"></p>
        <h2>Actores</h2>
        <p id="actores"></p>

    </section>

    <section class="botones" id="botones">

    </section>

    <a href="/logout">Cerrar sesion</a>

    <script>
        let nPaginas = 0

        async function getPelicula(pagina) {//Funcion para obtener una pelicula de una pagina en especifica
            //Se carga los elementos donde se mostrará la información
            const tituloText = document.getElementById("titulo")
            const fechaText = document.getElementById("fecha")
            const actoresText = document.getElementById("actores")

            //Token de la sesion
            const sessionToken = document.querySelector("meta[name='csrf_token']").getAttribute("content")

            //Petición a la pagina, al hacer una petición se obtiene la respuesta en texto plano
            const peliculaRes = await fetch("/getPeliculasPagina/"+pagina, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": sessionToken,
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            });

            //Se transforma la respuesta de texto plano a formato JSON para poder manipularlo
            const peliculaJson = await peliculaRes.json()

            //Se inserta la información a los elementos HTML
            tituloText.innerHTML = peliculaJson.nombre
            fechaText.innerHTML = peliculaJson.fecha
            actoresText.innerHTML = peliculaJson.actores

            console.log(peliculaJson)
        }

        async function getNPeliculas() {//Funcion para obtener el numero de paginas
            const sessionToken = document.querySelector("meta[name='csrf_token']").getAttribute("content")

            const nPeliculasRes = await fetch("/getNumeroPeliculas")

            const nPeliculasJson = await nPeliculasRes.json()

            nPaginas = nPeliculasJson
        }

        async function cargarPaginas() {//Funcion para generar los botones para las paginas
            await getNPeliculas()

            const botonesBox = document.getElementById("botones")

            for (let numeroPagina = 0; numeroPagina<nPaginas; numeroPagina++) {
                let boton = document.createElement("button")

                //Se añade sus atributos
                boton.innerHTML = numeroPagina
                boton.setAttribute("onclick", 'getPelicula('+numeroPagina+')')

                botonesBox.appendChild(boton)
            }

        }

        getPelicula(0)
        cargarPaginas()

    </script>

</body>
</html>
