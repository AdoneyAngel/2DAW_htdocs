<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\DeleteUsuarioRequest;
use App\Http\Requests\Usuario\IndexUsuarioRequest;
use App\Http\Requests\Usuario\ShowUsuarioRequest;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Http\Resources\Usuario\UsuarioCollection;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Models\TipoUsuario;
use App\Models\Usuario;

/**
 * @OA\Info(
 *      version="11.31",
 *      title="Supuesto UT5 Tejera Santana Adoney",
 *      description="Documentacion de supuesto ut5"
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Servidor principal de la API"
 * )
 */

class UsuarioController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/adoneytj/usuarios",
     *      operationId="index",
     *      tags={"Usuarios"},
     *      summary="Obtener lista de usuarios",
     *      description="Devuelve todos los usuarios, solo admin y gestores tienen autorización",
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o gestor"
     *      )
     * )
     */
    public function index(IndexUsuarioRequest $request) {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/usuarios",
     *      operationId="store",
     *      tags={"Usuarios"},
     *      summary="Crear un usuario",
     *      description="Crea un nuevo usuario, no puede repetirse el email, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "clave", "id_tipo_usuario"},
     *              @OA\Property(property="email", type="string", example="prueba@gmail.com"),
     *              @OA\Property(property="clave", type="string", example="1234"),
     *              @OA\Property(property="id_tipo_usuario", type="integer", example=1234)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o gestor"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function store(StoreUsuarioRequest $request) {
        $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

        if (!$tipoUsuario) {//Validar que el usuario existe
            return response("El tipo de usuario introducido n es válido", 205);
        }

        $nuevoUsuario = new Usuario($request->all());
        $nuevoUsuario->save();

        return new UsuarioResource($nuevoUsuario->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/usuarios",
     *      operationId="update",
     *      tags={"Usuarios"},
     *      summary="Actualiza un usuario",
     *      description="Actualiza un usuario, no puede repetirse el email, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="prueba@gmail.com"),
     *              @OA\Property(property="token", type="string", example="jfasf34232pf"),
     *              @OA\Property(property="clave", type="string", example="1234"),
     *              @OA\Property(property="id_tipo_usuario", type="integer", example=1234),
     *              @OA\Property(property="fecha_registro", type="date", example="2015-5-12")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o gestor"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o el usuario no existe"
     *      )
     * )
     */

    public function update(UpdateUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($request->id_tipo_usuario) {//Validar si cambia a un tipo de usuario valido
            $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

            if (!$tipoUsuario) {
                return response("El tipo de usuario introducido n es válido", 205);
            }
        }
        if ($request->fecha_registro) {//Validar fecha de registro
            if (!Utilities::validarFechaRegistro($request->fecha_registro)) {
                return response("La fecha de registro no es válido", 205);
            }
        }

        if ($usuario) {//Validar que el usuario existe
            $usuario->update($request->all());

            return new UsuarioResource($usuario->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/usuarios/{id_usuario}",
     *      operationId="show",
     *      tags={"Usuarios"},
     *      summary="Obtiene un usuario",
     *      description="Obtiene el usuario indicado, no puede repetirse el email, solo puede hacerlo o el propietario o si es admin/gestor",
     *      @OA\Parameter(
     *          name="id_usuario",
     *          description="ID del usuario",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, no es admin ni gestor ni el propietario"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o el usuario no existe"
     *      )
     * )
     */

    public function show(ShowUsuarioRequest $request, $usuarioId) {
        $usuarioGet = Usuario::find($usuarioId);
        $usuasrioRequest = $request->user();

        if (!$this->validar($usuasrioRequest, $usuarioGet)) {
            return AuthController::UnauthorizedError("No puede acceder a otro usuario");
        }

        if ($usuarioGet) {
            return new UsuarioResource($usuarioGet->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/usuarios/{id_usuario}",
     *      operationId="delete",
     *      tags={"Usuarios"},
     *      summary="Borra un usuario",
     *      description="Obtiene el usuario indicado, solo puede hacerlo el es admin o gestor",
     *      @OA\Parameter(
     *          name="id_usuario",
     *          description="ID del usuario",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o gestor"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o el usuario no existe"
     *      )
     * )
     */

    public function destroy(DeleteUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return response(true);

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/usuario_info/{id_usuario}",
     *      operationId="usuario_info",
     *      tags={"Usuarios"},
     *      summary="Información de usuario",
     *      description="Obtiene la información completa de un usuario",
     *      @OA\Parameter(
     *          name="id_usuario",
     *          description="ID del usuario",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin, gestor o el mismo usuario"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o el usuario no existe"
     *      )
     * )
     */

    public function usuario_info(ShowUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);
        $usuasrioRequest = $request->user();

        if (!$usuario) {
            return response("El usuario introducido no se ha encontrado", 205);
        }

        if (!$this->validar($usuasrioRequest, $usuario)) {
            return AuthController::UnauthorizedError("No puede acceder a otro usuario");
        }

        $usuario->tablasEntrenamiento();
        $usuario->series();
        $usuario->ejercicios();
        $usuario->entrenadores();
        $usuario->tiposMusculo();
        $usuario->nutricionistas();

        return new UsuarioResource($usuario->loadMissing(["planesEntrenamiento", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    private function validar(Usuario $usuario, Usuario $usuarioGet) {
        if (($usuario->id_usuario != $usuarioGet->id_usuario) && !Usuario::esGestor($usuario) && !Usuario::esAdmin($usuario)) {//Si no es gestor ni admin ni el mismo usuario no está autorizado
            return false;
        }

        return true;
    }

}
