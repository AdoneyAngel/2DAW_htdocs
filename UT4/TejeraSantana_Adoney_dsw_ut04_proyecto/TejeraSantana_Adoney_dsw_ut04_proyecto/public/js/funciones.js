let sessionToken = document.querySelector("meta[name='metaToken']").content
const View = document.getElementById("view")
const header = document.getElementById("header")
const usuarioLabel = document.getElementById("usuarioLabel")

let nombreUsuario

//########################Métodos########################
async function get(url) {
    const response = await fetch(url, {
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

async function put(url, params) {
    const response = await fetch(url, {
        method: "PUT",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        },
        body: new URLSearchParams(params)
    })

    const responseJson = await response.json()

    return responseJson
}

async function deleteMethod(url) {
    const response = await fetch(url, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-CSRF-TOKEN": sessionToken
        }
    })

    const responseJson = await response.json()

    return responseJson
}

async function isLogged() {
    const response = await get("/isLogged")

    if (response.respuesta) {
        nombreUsuario = response.usuario
        usuarioLabel.innerHTML = "Usuario: "+nombreUsuario

        mostrarHeader()

    } else if (response.error.length > 0) {
        alert("Error al verificar la sesión: "+response.error)

    } else {
        mostrarLogin()
    }

}

function alerta(mensaje) {
    alert(mensaje)
}
function mensaje(mensaje) {
    alert(mensaje)
}



//Formularios

async function login() {
    const usuarioInput = document.querySelector("#loginForm #usuario")
    const claveInput = document.querySelector("#loginForm #clave")

    if (usuarioInput.value.length > 0 && claveInput.value.length > 0) {
        try {
            const response = await post("/login", {usuario: usuarioInput.value, clave: claveInput.value})

            if (response.respuesta) {
                mostrarHeader()
                vaciarView()

            } else if (response.error.length) {
                alerta("Se producjo un error, no se ha podido iniciar sesión: servidor: "+response.error)

            } else {
                alerta("El usuario o contraseña no es válido")
            }

        } catch(exception) {
            alerta("Ha habido un error al iniciar sesion: "+exception)
        }

    } else {
        alerta("No pueden haber campos vacíos")
    }

}

async function logout() {
    try {
        const response = await get("/logout");

        if (response.respuesta) {
            sessionToken = response.token
            mensaje("Sesión cerrada con éxito")
            mostrarLogin()

        } else {
            throw new Error("servidor: "+response.error)
        }

    } catch (exception) {
        alerta("No se ha podido cerrar sesión: "+exception)
    }
}

//Formulario categoria
async function editarCategoriaForm(id) {
    try {
        const nombreCategoria = document.querySelector("#editarCategoriaForm #nombre").value
        const descripcionCategoria = document.querySelector("#editarCategoriaForm #descripcion").value

        if (nombreCategoria.length > 0 && descripcionCategoria.length > 0) {
            const response = await put("/categorias/"+id, {nombre: nombreCategoria, descripcion: descripcionCategoria})

            if (response.respuesta) {
                mensaje("Categoría editada con éxito")
                mostrarListaCategorias()

            } else {
                alerta("Ha habido un error de servidor al editar la categoría: "+response.error)
            }

        } else {
            alerta("No pueden haber campos vacíos")
        }

    } catch(exception) {
        alerta("Ha habido un error al editar la categoría: "+exception)
    }
}

async function añadirCategoria() {
    try {
        const nombre = document.querySelector("#añadirCategoriaForm #nombre").value
        const descripcion = document.querySelector("#añadirCategoriaForm #descripcion").value

        if (nombre.length > 0 && descripcion.length > 0) {
            const response = await post("/categorias", {nombre, descripcion})

            if (response.respuesta) {
                mensaje("Categoría añadida con éxito")
                mostrarListaCategorias()

            } else {
                alerta("Ha habido un error del servidor al añadir categoría: "+response.error)
            }

        } else {
            alerta("No pueden haber campos vacíos")
        }

    } catch (exception) {
        alerta("Ha habido un error al añadir la categoría: "+exception)
    }
}

async function eliminarCategoria(id) {
    const aceptado = confirm("¿Seguro desea eliminar la categoría?")

    if (aceptado) {
        const response = await deleteMethod("/categorias/"+id)

        if (response.respuesta) {
            mensaje("Categoría eliminada con éxito")
            mostrarListaCategorias()

        } else {
            alerta("Se produjo un error, no se pudo eliminar la categoría: " + response.error)
        }
    }
}

//Formulario producto
async function añadirProducto() {
    const nombre = document.querySelector("#añadirProductoForm #nombre").value
    const descripcion = document.querySelector("#añadirProductoForm #descripcion").value
    const categoria = document.querySelector("#añadirProductoForm #categoria").value
    const stock = document.querySelector("#añadirProductoForm #stock").value

    if (nombre.length > 0 && descripcion.length > 0 && categoria.length > 0 && stock.length > 0) {
        const response = await post("/productos", {nombre, descripcion, categoria, stock})

        if (response.respuesta) {
            mensaje("Producto añadido con éxito")
            mostrarListaCategorias()

        } else {
            alerta("Se produjo un error, no se pudo crear el producto: " + response.error)
        }

    } else {
        alerta("No puede haber campos vacíos")
    }
}

async function eliminarProducto(id) {
    const aceptado = confirm("¿Seguro desea eliminar el producto?")

    if (aceptado) {
        const response = await deleteMethod("/productos/"+id)

        if (response.respuesta) {
            mensaje("Producto eliminado con éxito")
            mostrarListaCategorias()

        } else {
            alerta("Se produjo un error, no se pudo eliminar el producto: " + response.error)
        }
    }
}

//Carrito
async function añadirProductoCarrito(id) {
    try {
        const unidades = document.querySelector("#producto_"+id+" #añadirProductoInput").value

        if (isNaN(Number(id))) {
            alerta("no modifique el contenido, el producto es inválido")
            return false
        }

        if (unidades > 0) {
            const response = await post("/carrito/save", {producto: id, unidades})

            if (response.respuesta) {
                mensaje("Producto añadido al carrito con éxito")

                mostrarCarrito()

            } else {
                alerta("Se produjo un error, no se pudo añadir el producto al carrito: servidor: "+response.error)
            }

        } else {
            alerta("Debe ingresar un número entero positivo mayor que 0")
        }

    } catch (exception) {
        alerta("Se produjo un error, no se pudo añadir el producto al carrito: " + exception)
    }
}
async function eliminarProductoCarrito(id) {
    try {
        const unidades = document.querySelector("#producto_"+id+" #añadirProductoInput").value

        //comprobar que las unidades son un número
        if (isNaN(Number(unidades))) {
            alerta("Número de unidades inválido")
            return false
        }
        if (unidades <= 0) {
            alerta("Debe ingresar un número de unidades entero positivo mayor que 0")
            return false
        }

        const response = await post("/carrito/remove", {producto: id, unidades})

        if (response.respuesta) {
            mensaje("Productos removidos con éxito")
            mostrarCarrito()

        } else {
            throw new Error("servidor: "+response.error)
        }

    } catch (exception) {
        alerta("Se produjo un error, no se pudo eliminar el producto del carrito: " + exception)
    }
}

//Relacionado con las vistas

function ocultarHeader() {
    header.style.display = "none"
}

function mostrarHeader() {
    header.style.display = "block"
}

async function cargarView(ruta, parametro = "") {
    vaciarView()

    const vista = await fetch(ruta+"/"+parametro)
    const vistaHtml = await vista.text()

    View.innerHTML = vistaHtml
}
function vaciarView() {
    const elementosView = View.childNodes

    elementosView.forEach(el => el.remove())
}

async function mostrarLogin() {
    ocultarHeader()
    cargarView("/loginView")
}

async function mostrarListaCategorias() {
    cargarView("/categorias")
}

async function mostrarListaCategoriaProductos(id) {
    cargarView("/categorias/"+id+"/productos")
}

async function mostrarEditarCategoria(id) {
    cargarView("/categorias/"+id+"/edit")
}

async function mostrarAñadirCategoria() {
    cargarView("/categorias/create")
}

async function mostrarAñadirProducto() {
    cargarView("/productos/create")
}

async function mostrarCarrito() {
    cargarView("/carrito")
}

async function realizarPedido() {
    cargarView("/pedido/realizar")
}

//########################Funciones iniciales########################
//Comprobar que está logueado
ocultarHeader()
isLogged()
