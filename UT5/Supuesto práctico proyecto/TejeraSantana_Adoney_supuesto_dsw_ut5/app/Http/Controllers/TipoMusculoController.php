<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoMusculo\DeleteTipoMusculoRequest;
use App\Http\Requests\TipoMusculo\IndexTipoMusculorequest;
use App\Http\Requests\TipoMusculo\ShowTipoMusculorequest;
use App\Http\Requests\TipoMusculo\StoreTipoMusculoRequest;
use App\Http\Requests\TipoMusculo\UpdateTipoMusculoRequest;
use App\Http\Resources\TipoMusculo\TipoMusculoCollection;
use App\Http\Resources\TipoMusculo\TipoMusculoResource;
use App\Models\TipoMusculo;

class TipoMusculoController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_musculo",
     *      operationId="indexTiposMusculo",
     *      tags={"Tipos_musculo"},
     *      summary="Listar todos los tipos de músculos",
     *      description="Lista todos los tipos de músculos, solo admin",
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin"
     *      )
     * )
     */
    public function index(IndexTipoMusculorequest $request) {
        $tiposMusculo = TipoMusculo::all();

        return new TipoMusculoCollection($tiposMusculo->loadMissing("ejercicios"));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/tipos_musculo",
     *      operationId="storeTiposMusculo",
     *      tags={"Tipos_musculo"},
     *      summary="Crear tipo de músculo",
     *      description="Crea un tipo de músculo, solo admin",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"nombre", "descripcion"},
     *              @OA\Property(property="nombre", type="string", example="Muslo"),
     *              @OA\Property(property="descripcion", type="string", example="Musculo grande"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function store(StoreTipoMusculoRequest $request) {
        $tipoMusculo = new TipoMusculo($request->all());
        $tipoMusculo->save();

        return new TipoMusculoResource($tipoMusculo->loadMissing("ejercicios"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/tipos_musculo/{id_tipo_musculo}",
     *      operationId="updateTiposMusculo",
     *      tags={"Tipos_musculo"},
     *      summary="Actualizar tipo de músculo",
     *      description="Actualiza un tipo de músculo, solo admin",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Muslo"),
     *              @OA\Property(property="descripcion", type="string", example="Musculo grande"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tipo_musculo",
     *          description="ID del tipo de músculo",
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
     *          description="Sin autorización, debe ser admin"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o no existe el tipo de músculo"
     *      )
     * )
     */
    public function update(UpdateTipoMusculoRequest $request, $tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            $tipoMusculo->update($request->all());

            return new TipoMusculoResource($tipoMusculo->loadMissing("ejercicios"));

        } else {
            return response("No existe el tipo de músculo indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_musculo/{id_tipo_musculo}",
     *      operationId="showTiposMusculo",
     *      tags={"Tipos_musculo"},
     *      summary="Obtener tipo de músculo",
     *      description="Obtiene un tipo de músculo, solo admin",
     *      @OA\Parameter(
     *          name="id_tipo_musculo",
     *          description="ID del tipo de músculo",
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
     *          description="Sin autorización, debe ser admin"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o no existe el tipo de músculo"
     *      )
     * )
     */
    public function show(ShowTipoMusculorequest $request, $tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            return new TipoMusculoResource($tipoMusculo->loadMissing("ejercicios"));

        } else {
            return response("No existe el tipo de músculo indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/tipos_musculo/{id_tipo_musculo}",
     *      operationId="destroyTiposMusculo",
     *      tags={"Tipos_musculo"},
     *      summary="Borrar tipo de músculo",
     *      description="Borra un tipo de músculo, solo admin",
     *      @OA\Parameter(
     *          name="id_tipo_musculo",
     *          description="ID del tipo de músculo",
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
     *          description="Sin autorización, debe ser admin"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="No existe el tipo de músculo"
     *      )
     * )
     */
    public function destroy(DeleteTipoMusculoRequest $request, $tipoMusculoId) {
        $tipoMusculo = TipoMusculo::find($tipoMusculoId);

        if ($tipoMusculo) {
            $tipoMusculo->delete();

            return response(true);

        } else {
            return response("No existe tipo de músculo indicado", 205);
        }
    }
}
