<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoSerie\DeleteTipoSerieRequest;
use App\Http\Requests\TipoSerie\StoreTipoSerieRequest;
use App\Http\Requests\TipoSerie\UpdateTipoSerieRequest;
use App\Http\Resources\TipoSerie\TipoSerieCollection;
use App\Http\Resources\TipoSerie\TipoSerieResource;
use App\Models\TipoSerie;
use Illuminate\Http\Request;

class TipoSerieController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_serie",
     *      operationId="indexTiposSerie",
     *      tags={"Tipos_serie"},
     *      summary="Listar todos los tipos de serie",
     *      description="Lista todos los tipos de serie, solo admin y entrenadores están autorizados",
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o entrenador"
     *      )
     * )
     */
    public function index() {
        $tiposSerie = TipoSerie::all();

        return new TipoSerieCollection($tiposSerie->loadMissing(["series"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/tipos_serie",
     *      operationId="storeTiposSerie",
     *      tags={"Tipos_serie"},
     *      summary="Crear un tipo de serie",
     *      description="Crea un tipo de serie, solo admin y entrenadores están autorizados",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"nombre", "descripcion"},
     *              @OA\Property(property="nombre", type="string", example="Serie de netflix"),
     *              @OA\Property(property="descripcion", type="string", example="Serie larga"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Agún parámetro inválido"
     *      )
     * )
     */
    public function store(StoreTipoSerieRequest $request) {
        $tipoSerie = new TipoSerie($request->all());
        $tipoSerie->save();

        return new TipoSerieResource($tipoSerie->loadMissing(["series"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/tipos_serie/{id_tipo_serie}",
     *      operationId="updateTiposSerie",
     *      tags={"Tipos_serie"},
     *      summary="Actualizar un tipo de serie",
     *      description="Actualiza un tipo de serie, solo admin y entrenadores están autorizados",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Serie de netflix"),
     *              @OA\Property(property="descripcion", type="string", example="Serie larga"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tipo_serie",
     *          description="ID del tipo de serie",
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
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Agún parámetro inválido o no se encuentra el tipo de serie"
     *      )
     * )
     */
    public function update(UpdateTipoSerieRequest $request, $tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            $tipoSerie->update($request->all());

            return new TipoSerieResource($tipoSerie->loadMissing(["series"]));

        } else {
            return response("No existe el tipo de serie indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/tipos_serie/{id_tipo_serie}",
     *      operationId="showTiposSerie",
     *      tags={"Tipos_serie"},
     *      summary="Obtener un tipo de serie",
     *      description="Obtiene un tipo de serie, solo admin y entrenadores están autorizados",
     *      @OA\Parameter(
     *          name="id_tipo_serie",
     *          description="ID del tipo de serie",
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
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="No se encuentra el tipo de serie"
     *      )
     * )
     */
    public function show($tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            return new TipoSerieResource($tipoSerie->loadMissing(["series"]));

        } else {
            return response("No existe el tipo de serie indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/tipos_serie/{id_tipo_serie}",
     *      operationId="destroyTiposSerie",
     *      tags={"Tipos_serie"},
     *      summary="Borrar un tipo de serie",
     *      description="Borra un tipo de serie, solo admin y entrenadores están autorizados",
     *      @OA\Parameter(
     *          name="id_tipo_serie",
     *          description="ID del tipo de serie",
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
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="No se encuentra el tipo de serie"
     *      )
     * )
     */
    public function destroy(DeleteTipoSerieRequest $request, $tipoSerieId) {
        $tipoSerie = TipoSerie::find($tipoSerieId);

        if ($tipoSerie) {
            $tipoSerie->delete();

            return response(true);

        } else {
            return response("No existe el tipo de serie indicado", 205);
        }
    }
}
