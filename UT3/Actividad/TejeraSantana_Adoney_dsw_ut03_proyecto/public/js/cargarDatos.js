//---------------------Variables estaticas
const loginInputUsuario = document.getElementById("usuarioInput")
const loginInputClave = document.getElementById("claveInput")
const cabecera = document.getElementById("cabecera")
let usuario = null
const idViews = ["login", "lista_libros", "lista_carrito", "lista_generos", "lista_libros_genero", "lista_pedidos", "lista_accesos"]
const botonesCabecera = [
    {
        metodo: "cargarGeneros()",
        nombre: "Lista de Generos"
    },
    {
        metodo: "cargarLibros()",
        nombre: "Lista de Libros"
    },
    {
        metodo: "cargarCarrito()",
        nombre: "Ver carrito"
    },
    {
        metodo: "obtenerPedidos()",
        nombre: "Pedidos"
    },
    {
        metodo: "obtenerAccesos()",
        nombre: "Accesos"
    },
    {
        metodo: "logout()",
        nombre: "Cerrar sesión"
    }
]

//Token
let sessionToken = document.querySelector("meta[name='token']").getAttribute("content");

//---------------------Funciones "privadas o propias"
async function getUsuario() {
    const usuario = await get("/cargarUsuario")

    if (usuario) {
        if (usuario.error) {
            message(usuario.error)
            return false
        }

        return usuario
    }
}

function vaciarContenidoTabla(idTabla) {
    if (!idTabla) {
        console.error("Faltan parámetros")
        return false;
    }

    const contenidoTbody = document.querySelectorAll("#"+idTabla+" > table tbody tr")

    for (let trActual of contenidoTbody) {
        trActual.remove()
    }

}

function message(txt) {
    alert(txt)
}

async function get(url, params = "") {
    const response = await fetch(url+"/"+params, {
        method: "GET",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        }
    })

    const responseJson = await response.json()

    return responseJson
}

async function post(url, params) {
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        },
        body: new URLSearchParams(params)
    })

    const responseJson = await response.json()

    return responseJson
}

async function isLogged() {
    const responseJson = await get("/isLogged")

    if (responseJson.error) {
        console.log("Error al comprobar si está logueado: " + response.error)
    }

    return responseJson.respuesta
}

function hiddeViews() {
    for (let viewIndex = 0; viewIndex<idViews.length; viewIndex++) {
        const vistaDoc = document.getElementById(idViews[viewIndex])

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
    const usuarioInput = loginInputUsuario.value
    const clave = loginInputClave.value

    const responseJson = await post("/login", {
        usuario: usuarioInput,
        clave
    })

    if (responseJson.respuesta == true) {
        cabecera.style.display = "block"
        document.getElementById("usuarioHeader").innerHTML = "Usuario: "+  usuarioInput

        hiddeViews()
    }

}

async function logout() {
    const responseJson = await get("/logout")

    if (responseJson.respuesta == true) {
        showView("login")
        cabecera.style.display = "none"
        document.getElementById("usuarioHeader").innerHTML = ""
        usuario = null

        sessionToken = responseJson.token
    }
}

async function añadirLibros(isbn, unidades) {

    if (unidades > 0) {
        const responseJson = await post("/agregarLibros", {
            isbn,
            unidades
        })

        if (responseJson.error.length == 0) {
            message("Productos añadidos con éxito")

        } else {
            message(responseJson.error)
        }
    }
}

async function eliminarLibros(isbn, unidades) {
    if (unidades > 0) {
        const responseJson = await post("/eliminarLibros", {
            isbn,
            unidades
        })

        if (responseJson.error.length == 0) {
            message("Productos eliminados con éxito")

        }  else {
            message(responseJson.error)
        }
    }
}

async function cargarLibros() {
    const tablaTbody = document.querySelector("#lista_libros > table tbody")

    const responseJson = await get("/cargarLibros")

    showView("lista_libros")

    //Borrar lineas tabla
    vaciarContenidoTabla("lista_libros");

    //Mostrar libros por pantalla
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

        trDoc.id = libro.isbn

        const imgImagen = document.createElement("img")
        imgImagen.src = libro.imagen
        imgImagen.width = "50"

        thImagen.appendChild(imgImagen)

        const inputOperaciones = document.createElement("input")
        inputOperaciones.className = "operacionInput"
        inputOperaciones.type = "number"
        inputOperaciones.min = "0"

        const sumarOperaciones = document.createElement("button")
        sumarOperaciones.innerHTML = "+"
        sumarOperaciones.className = "btn btn-success"
        sumarOperaciones.addEventListener("click", () => {
            añadirLibros(libro.isbn, inputOperaciones.value)
            cargarLibros()
        })

        thOperaciones.appendChild(inputOperaciones)
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

async function cargarCarrito() {
    const responseJson = await get("/cargarCarrito")

    showView("lista_carrito")

    //se saca los numunidades y numarticulos del resto de elementos y se borra del array
    const nums = responseJson[0]
    delete responseJson[0]

    //Borrar lineas tabla
    vaciarContenidoTabla("lista_carrito");

    const tablaTbody = document.querySelector("#lista_carrito > table tbody")
    const carritoUnidadesTxt = document.getElementById("carritoUnidades")
    const carritoArticulosTxt = document.getElementById("carritoArticulos")

    carritoUnidadesTxt.innerHTML = "Número de unidades: " + nums["numunidades"]
    carritoArticulosTxt.innerHTML = "Número de artículos: " + nums["numarticulos"]

    //Mostrar libros por pantalla
    for(let libro of responseJson) {
        if (!libro) {
            continue
        }

        const trDoc = document.createElement("tr")
        const thIsbn = document.createElement("th")
        const thTitulo = document.createElement("th")
        const thGenero = document.createElement("th")
        const thImagen = document.createElement("th")
        const thEscritores = document.createElement("th")
        const thPaginas = document.createElement("th")
        const thUnidades = document.createElement("th")
        const thOperaciones = document.createElement("th")

        trDoc.id = libro.isbn

        const imgImagen = document.createElement("img")
        imgImagen.src = libro.imagen
        imgImagen.width = "50"

        thImagen.appendChild(imgImagen)

        const inputOperaciones = document.createElement("input")
        inputOperaciones.className = "operacionInput"
        inputOperaciones.type = "number"
        inputOperaciones.min = "0"

        const sumarOperaciones = document.createElement("button")
        sumarOperaciones.innerHTML = "+"
        sumarOperaciones.className = "btn btn-success"
        sumarOperaciones.addEventListener("click", () => {
            añadirLibros(libro.isbn, inputOperaciones.value)
            cargarCarrito();
        })

        const restaOperaciones = document.createElement("button")
        restaOperaciones.innerHTML = "-"
        restaOperaciones.className = "btn btn-danger"
        restaOperaciones.addEventListener("click", () => {
            eliminarLibros(libro.isbn, inputOperaciones.value)
            cargarCarrito();
        })

        thOperaciones.appendChild(inputOperaciones)
        thOperaciones.appendChild(sumarOperaciones)
        thOperaciones.appendChild(restaOperaciones)

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

async function cargarGeneros() {
    const generos = await get("/cargarGeneros");

    const ulDoc = document.querySelector("#lista_generos > ul")
    const liDocs = document.querySelectorAll("#lista_generos > ul li")

    let nGeneros = generos.length

    //Borrar todas las lineas de la lista
    for (let element of liDocs) {
        element.remove()
    }

    //Generar lineas de lista
    for (let genero of generos) {
        const newLiDoc = document.createElement("li")
        newLiDoc.id = genero.cod

        const newLiButton = document.createElement("a")
        newLiButton.innerHTML = genero.nombre
        newLiButton.href = "#"
        newLiButton.addEventListener("click", () => cargarGeneroLibros(genero.nombre))

        newLiDoc.appendChild(newLiButton)
        ulDoc.appendChild(newLiDoc)
    }

    if (!nGeneros) {
        ulDoc.innerHTML = "No hay generos"
    }

    showView("lista_generos")

}

async function cargarGeneroLibros(genero) {
    if (!genero || !genero.length) {
        return false;
    }

    const libros = await get("/cargarGeneroLibros", genero)

    console.log(libros)

    //Vaciar tabla
    vaciarContenidoTabla("lista_libros_genero");

    //Generar tabla
    const tablaTbody = document.querySelector("#lista_libros_genero > table tbody")

    for(let libro of libros) {
        const trDoc = document.createElement("tr")
        const thIsbn = document.createElement("th")
        const thTitulo = document.createElement("th")
        const thGenero = document.createElement("th")
        const thImagen = document.createElement("th")
        const thEscritores = document.createElement("th")
        const thPaginas = document.createElement("th")

        trDoc.id = libro.isbn

        const imgImagen = document.createElement("img")
        imgImagen.src = libro.imagen
        imgImagen.width = "50"

        thImagen.appendChild(imgImagen)

        thIsbn.innerHTML = libro.isbn
        thTitulo.innerHTML = libro.titulo
        thGenero.innerHTML = libro.genero
        thEscritores.innerHTML = libro.escritores
        thPaginas.innerHTML = libro.numpaginas

        trDoc.appendChild(thIsbn)
        trDoc.appendChild(thTitulo)
        trDoc.appendChild(thEscritores)
        trDoc.appendChild(thGenero)
        trDoc.appendChild(thPaginas)
        trDoc.appendChild(thImagen)

        tablaTbody.append(trDoc)
    }

    showView("lista_libros_genero")
}

async function obtenerPedidos() {
    hiddeViews()

    const tablaTbody = document.querySelector("#lista_pedidos > table tbody")

    const pedidos = await get("/obtenerPedidos")

    //Borrar lineas tabla
    vaciarContenidoTabla("lista_pedidos");

    showView("lista_pedidos")

    //Mostrar libros por pantalla
    for(let pedido of pedidos) {
        const trDoc = document.createElement("tr")
        const thIsbn = document.createElement("th")
        const thFecha = document.createElement("th")
        const thUsuario = document.createElement("th")
        const thTitulo = document.createElement("th")
        const thGenero = document.createElement("th")
        const thImagen = document.createElement("th")
        const thEscritores = document.createElement("th")
        const thPaginas = document.createElement("th")
        const thUnidades = document.createElement("th")
        const thOperaciones = document.createElement("th")

        trDoc.id = pedido.isbn

        const imgImagen = document.createElement("img")
        imgImagen.src = pedido.imagen
        imgImagen.width = "50"

        thImagen.appendChild(imgImagen)

        const cancelarOperacion = document.createElement("button")
        cancelarOperacion.innerHTML = "Cancelar"
        cancelarOperacion.addEventListener("click", () => {})
        cancelarOperacion.className = "btn btn-danger"

        thOperaciones.appendChild(cancelarOperacion)

        thIsbn.innerHTML = pedido.isbn
        thFecha.innerHTML = pedido.fecha
        thTitulo.innerHTML = pedido.titulo
        thGenero.innerHTML = pedido.genero
        thUsuario.innerHTML = pedido.usuario
        thEscritores.innerHTML = pedido.escritores
        thPaginas.innerHTML = pedido.numpaginas
        thUnidades.innerHTML = pedido.unidades

        trDoc.appendChild(thUsuario)
        trDoc.appendChild(thIsbn)
        trDoc.appendChild(thTitulo)
        trDoc.appendChild(thEscritores)
        trDoc.appendChild(thGenero)
        trDoc.appendChild(thPaginas)
        trDoc.appendChild(thImagen)
        trDoc.appendChild(thUnidades)
        trDoc.appendChild(thFecha)
        trDoc.appendChild(thOperaciones)

        tablaTbody.append(trDoc)
    }

}

async function obtenerAccesos() {
    hiddeViews()

    const accesos = await get("/obtenerAccesos");
    const tablaTbody = document.querySelector("#lista_accesos > table tbody")

    //Mostrar libros por pantalla
    for(let acceso of accesos) {
        const trDoc = document.createElement("tr")
        const thUsuario = document.createElement("th")
        const thFechaInicio = document.createElement("th")
        const thFechaFinal = document.createElement("th")

        thUsuario.innerHTML = acceso.usuario
        thFechaInicio.innerHTML = acceso.fecha_acceso
        thFechaFinal.innerHTML = acceso.fecha_cierre

        trDoc.appendChild(thUsuario)
        trDoc.appendChild(thFechaInicio)
        trDoc.appendChild(thFechaFinal)

        tablaTbody.append(trDoc)
    }

    showView("lista_accesos")
}
//---------------------


//---------------------Inicio de la página
hiddeViews()//Ocultar todas las vistas
generarBotonesCabecera()

//Nada mas iniciar comprobar que tiene una sesión creada
isLogged().then(async isLogged => {

    if (!isLogged) {
        showView("login")
        cabecera.style.display = "none"

    } else {
        cabecera.style.display = "block"
        usuario = await getUsuario();
        document.getElementById("usuarioHeader").innerHTML = "Usuario: " + usuario
    }

})
