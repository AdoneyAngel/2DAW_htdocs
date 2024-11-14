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
        metodo: null,
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
    const views = ["login"]

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
        boton.addEventListener("onclick", botonData.metodo)

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

    const response = await fetch("/login", {
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

    cabecera.style.display = "block"

    hiddeViews()
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
