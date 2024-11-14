//---------------------Variables estaticas
const loginInputUsuario = document.getElementById("usuarioInput")
const loginInputClave = document.getElementById("claveInput")
const cabecera = document.getElementById("cabecera")
const botonesCabecera = [
    {
        metodo: null,
        nombre: "Lista de Generos"
    },
    {
        metodo: "cargarLibros()",
        nombre: "Lista de Libros"
    },
    {
        metodo: null,
        nombre: "Ver carrito"
    },
    {
        metodo: null,
        nombre: "Pedidos"
    },
    {
        metodo: null,
        nombre: "Accesos"
    },
    {
        metodo: "logout()",
        nombre: "Cerrar sesión"
    }
]

//Token
const sessionToken = document.querySelector("meta[name='token']").getAttribute("content");

//---------------------Funciones "privadas o propias"
async function isLogged() {
    const response = await fetch("/isLogged", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        }
    })

    const responseJson = await response.json()

    if (response.error) {
        console.log("Error al comprobar si está logueado: " + response.error)
    }

    return responseJson.respuesta
}

function hiddeViews() {
    const views = ["login", "lista_libros"]

    for (let viewIndex = 0; viewIndex<views.length; viewIndex++) {
        const vistaDoc = document.getElementById(views[viewIndex])

        vistaDoc.style.display = "none"
    }
}

function showView(viewId) {
    hiddeViews()

    const vistaDoc = document.getElementById(viewId)

    vistaDoc.style.display = "block"
}

function generarBotonesCabecera() {
    for (let botonData of botonesCabecera) {
        const boton = document.createElement("a")
        const separator = document.createElement("div")

        boton.innerHTML = botonData.nombre
        boton.href = "#"
        boton.setAttribute("onclick", botonData.metodo)

        separator.innerHTML = "/"
        separator.style.display = "inline-block"
        separator.style.margin = "0 5px"

        cabecera.appendChild(boton)
        cabecera.appendChild(separator)
    }
}
//---------------------

//---------------------Funciones obligatorias
async function login() {
    const usuario = loginInputUsuario.value
    const clave = loginInputClave.value

    const response = await fetch("login", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        },
        body: new URLSearchParams({
            usuario,
            clave
        })
    })

    const responseJson = await response.json()

    if (responseJson.respuesta == true) {
        cabecera.style.display = "block"

        hiddeViews()
    }

}

async function logout() {
    const response = await fetch("/logout", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        }
    })

    const responseJson = await response.json()

    if (responseJson.respuesta == true) {
        showView("login")
        cabecera.style.display = "none"
    }
}

async function cargarLibros() {
    const tablaTbody = document.querySelector("#lista_libros > table tbody")

    const response = await fetch("/cargarLibros", {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        }
    })

    const responseJson = await response.json()

    console.log(responseJson)

    //Mostrar libros por pantalla
    showView("lista_libros")

    for(let libro of responseJson) {
        const trDoc = document.createElement("tr")
        const thIsbn = document.createElement("th")
        const thTitulo = document.createElement("th")
        const thGenero = document.createElement("th")
        const thImagen = document.createElement("th")
        const thEscritores = document.createElement("th")
        const thPaginas = document.createElement("th")
        const thUnidades = document.createElement("th")
        const thOperaciones = document.createElement("th")

        const imgImagen = document.createElement("img")
        imgImagen.src = libro.imagen
        imgImagen.width = "50"

        thImagen.appendChild(imgImagen)

        const inputOperaciones = document.createElement("input")
        inputOperaciones.type = "number"

        const restarOperaciones = document.createElement("button")
        const sumarOperaciones = document.createElement("button")
        restarOperaciones.innerHTML = "-"
        sumarOperaciones.innerHTML = "+"

        thOperaciones.appendChild(inputOperaciones)
        thOperaciones.appendChild(restarOperaciones)
        thOperaciones.appendChild(sumarOperaciones)

        thIsbn.innerHTML = libro.isbn
        thTitulo.innerHTML = libro.titulo
        thGenero.innerHTML = libro.genero
        thEscritores.innerHTML = libro.escritores
        thPaginas.innerHTML = libro.numpaginas
        thUnidades.innerHTML = libro.unidades

        trDoc.appendChild(thIsbn)
        trDoc.appendChild(thTitulo)
        trDoc.appendChild(thEscritores)
        trDoc.appendChild(thGenero)
        trDoc.appendChild(thPaginas)
        trDoc.appendChild(thImagen)
        trDoc.appendChild(thUnidades)
        trDoc.appendChild(thOperaciones)

        tablaTbody.append(trDoc)
    }

}
//---------------------


//---------------------Inicio de la página
hiddeViews()//Ocultar todas las vistas
generarBotonesCabecera()

//Nada mas iniciar comprobar que tiene una sesión creada
isLogged().then(isLogged => {

    if (!isLogged) {
        showView("login")
        cabecera.style.display = "none"

    } else {
        cabecera.style.display = "block"
    }

})
