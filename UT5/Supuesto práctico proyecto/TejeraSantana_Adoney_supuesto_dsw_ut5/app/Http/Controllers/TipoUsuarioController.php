<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoUsuario\DeleteTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\IndexTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\ShowTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\StoreTipoUsuarioRequest;
use App\Http\Requests\TipoUsuario\UpdateTipoUsuarioRequest;
use App\Http\Resources\TipoUsuario\TipoUsuarioCollection;
use App\Http\Resources\TipoUsuario\TipoUsuarioResource;
use App\Models\TipoUsuario;

class TipoUsuarioController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_usuario",
     *      operationId="indexTiposUsuario",
     *      tags={"Tipos_usuario"},
     *      summary="Listar todos los tipos de usuario",
     *      description="Lista todos los tipos de usuario, solo admin y gestores están autorizados",
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
    public function index(IndexTipoUsuarioRequest $request) {
        $tiposUsuario = TipoUsuario::all();

        return new TipoUsuarioCollection($tiposUsuario->loadMissing("usuarios"));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/tipos_usuario",
     *      operationId="storeTiposUsuario",
     *      tags={"Tipos_usuario"},
     *      summary="Crear tipo de usuario",
     *      description="Crea un tipo de usuario, solo admin y gestores están autorizados",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"tipo_usuario", "descripcion"},
     *              @OA\Property(property="tipo_usuario", type="string", example="Usuario comun"),
     *              @OA\Property(property="descripcion", type="string", example="Permisos limitados a visualizar"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o gestor"
     *      )
     * )
     */
    public function store(StoreTipoUsuarioRequest $request) {
        $nuevoTipoUsuario = new TipoUsuario($request->all());
        $nuevoTipoUsuario->save();

        return new TipoUsuarioResource($nuevoTipoUsuario->loadMissing("usuarios"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/tipos_usuario/{id_tipo_usuario}",
     *      operationId="updateTiposUsuario",
     *      tags={"Tipos_usuario"},
     *      summary="Actualizar tipo de usuario",
     *      description="Actualiza un tipo de usuario, solo admin y gestores están autorizados",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="tipo_usuario", type="string", example="Usuario comun"),
     *              @OA\Property(property="descripcion", type="string", example="Permisos limitados a visualizar"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tipo_usuario",
     *          description="ID del tipo de usuario",
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
     *          description="Algún parámetro inválido o no se ha encontrado el tipo de usuario"
     *      )
     * )
     */
    public function update(UpdateTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->update($request->all());

            return new TipoUsuarioResource($tipoUsuario->loadMissing("usuarios"));

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_usuario/{id_tipo_usuario}",
     *      operationId="showTiposUsuario",
     *      tags={"Tipos_usuario"},
     *      summary="Obtener tipo de usuario",
     *      description="Obtiene un tipo de usuario, solo admin y gestores están autorizados",
     *      @OA\Parameter(
     *          name="id_tipo_usuario",
     *          description="ID del tipo de usuario",
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
     *          description="No se ha encontrado el tipo de usuario"
     *      )
     * )
     */
    public function show(ShowTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            return new TipoUsuarioResource($tipoUsuario->loadMissing("usuarios"));

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/tipos_usuario/{id_tipo_usuario}",
     *      operationId="destroyTiposUsuario",
     *      tags={"Tipos_usuario"},
     *      summary="Borrar tipo de usuario",
     *      description="Borra un tipo de usuario, solo admin y gestores están autorizados",
     *      @OA\Parameter(
     *          name="id_tipo_usuario",
     *          description="ID del tipo de usuario",
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
     *          description="No se ha encontrado el tipo de usuario"
     *      )
     * )
     */
    public function destroy(DeleteTipoUsuarioRequest $request, $tipoUsuarioId) {
        $tipoUsuario = TipoUsuario::find($tipoUsuarioId);

        if ($tipoUsuario) {
            $tipoUsuario->delete();

            return response(true);

        } else {
            return response("No existe el tipo de usuario indicado", 205);
        }
    }
}
