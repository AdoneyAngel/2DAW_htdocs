<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilUsuario\DeletePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\IndexPerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\ShowPerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\StorePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/perfiles_usuario",
     *      operationId="indexPerfilesUsuario",
     *      tags={"Perfiles_usuario"},
     *      summary="Listar perfiles de usuarios",
     *      description="Lista todos los perfiles de usuarios, solo admin y gestores tienen autorización",
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
    public function index(IndexPerfilUsuarioRequest $request) {
        $perfilesUsuarios = PerfilUsuario::all();

        return new PerfilUsuarioCollection($perfilesUsuarios->loadMissing(["usuario"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/perfiles_usuario",
     *      operationId="storePerfilesUsuario",
     *      tags={"Perfiles_usuario"},
     *      summary="Crear un perfil de uusario",
     *      description="Crear un perfil de usuario, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"nombre", "apellido1", "apellido2", "edad", "direccion", "telefono", "foto", "fecha_nacimiento", "id_usuario"},
     *              @OA\Property(property="nombre", type="string", example="Juan"),
     *              @OA\Property(property="apellido1", type="string", example="De las Montañas"),
     *              @OA\Property(property="apellido2", type="string", example="Y del pino"),
     *              @OA\Property(property="edad", type="integer", example=83),
     *              @OA\Property(property="direccion", type="string", example="En la montaña portal 0"),
     *              @OA\Property(property="telefono", type="string", example="123-12-12-12"),
     *              @OA\Property(property="foto", type="string", example="foto.com/id"),
     *              @OA\Property(property="fecha_nacimiento", type="date", example="1433-4-13"),
     *              @OA\Property(property="id_usuario", type="integert", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
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
    public function store(StorePerfilUsuarioRequest $request) {
        $cliente = Usuario::find($request->id_usuario);

        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if ($request->edad < 12) {
            return response("La edad debe ser de al menos 12 años", 205);
        }
        if (!Utilities::validarFechaEdad($request->fecha_nacimiento, $request->edad)) {//Valida que la fecha de nacimiento coincide con la edad introducida
            return response("La fecha no es válida o no coincide con la edad introducida", 205);
        }

        $perfilUsuario = new PerfilUsuario($request->all());
        $perfilUsuario->save();

        return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/perfiles_usuario/{id_perfil}",
     *      operationId="updatePerfilesUsuario",
     *      tags={"Perfiles_usuario"},
     *      summary="Actualizar un perfil de uusario",
     *      description="Actualizar un perfil de usuario, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Juan"),
     *              @OA\Property(property="apellido1", type="string", example="De las Montañas"),
     *              @OA\Property(property="apellido2", type="string", example="Y del pino"),
     *              @OA\Property(property="edad", type="integer", example=83),
     *              @OA\Property(property="direccion", type="string", example="En la montaña portal 0"),
     *              @OA\Property(property="telefono", type="string", example="123-12-12-12"),
     *              @OA\Property(property="foto", type="string", example="foto.com/id"),
     *              @OA\Property(property="fecha_nacimiento", type="date", example="1433-4-13"),
     *              @OA\Property(property="id_usuario", type="integert", example=1),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_perfil",
     *          description="ID del perfil",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=201,
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
    public function update(UpdatePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        //Comprobaciones
        if ($request->id_usuario) {

            $cliente = Usuario::find($request->id_usuario);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 401);
            }
        }
        if (is_numeric($request->edad) && $request->edad < 12) {
            return response("La edad debe ser de al menos 12 años", 205);
        }
        if ($request->fecha_nacimiento != null && !Utilities::validarFechaNacimiento($request->fecha_nacimiento)) {//Valida que la fecha de nacimiento coincide con la edad introducida
            return response("La fecha no es válida", 205);
        }

        if ($perfilUsuario) {
            $perfilUsuario->update($request->all());

            //Si se ha modificado la fecha de naciemiento se modificará tambien la edad
            if ($request->fecha_nacimiento != null) {
                $nuevaEdad = Utilities::calcEdad($request->fecha_nacimiento);

                $perfilUsuario->edad = (int) $nuevaEdad;
                $perfilUsuario->save();
            }

            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/perfiles_usuario/{id_perfil}",
     *      operationId="showPerfilesUsuario",
     *      tags={"Perfiles_usuario"},
     *      summary="Obtener un perfil de uusario",
     *      description="Obtiene un perfil de usuario, solo admin, gestores y el mismo uusario tienen autorización",
     *      @OA\Parameter(
     *          name="id_perfil",
     *          description="ID del perfil",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin, gestor o el mismo usuario"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function show(ShowPerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);
        $usuario = $request->user();

        if (!$this->validar($usuario, $perfilUsuario)) {//Si no es gestor ni el propietario ni admin no está autorizado
            return AuthController::UnauthorizedError();
        }
        if ($perfilUsuario) {
            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/perfiles_usuario/{id_perfil}",
     *      operationId="destroyPerfilesUsuario",
     *      tags={"Perfiles_usuario"},
     *      summary="Borrar un perfil de uusario",
     *      description="Borra un perfil de usuario, solo admin y gestores tienen autorización",
     *      @OA\Parameter(
     *          name="id_perfil",
     *          description="ID del perfil",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=201,
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
    public function destroy(DeletePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    private function validar(Usuario $usuario, PerfilUsuario $perfil) {
        if (($usuario->id_usuario != $perfil->id_usuario) && !Usuario::esGestor($usuario) && !Usuario::esAdmin($usuario)) {//Si no es gestor ni admin no está autorizado
            return false;
        }

        return true;
    }
}
