<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ejercicio\DeleteEjercicioRequest;
use App\Http\Requests\Ejercicio\IndexEjercicioRequest;
use App\Http\Requests\Ejercicio\ShowEjercicioRequest;
use App\Http\Requests\Ejercicio\StoreEjercicioRequest;
use App\Http\Requests\Ejercicio\UpdateEjercicioRequest;
use App\Http\Resources\Ejercicio\EjercicioCollection;
use App\Http\Resources\Ejercicio\EjercicioResource;
use App\Models\Ejercicio;
use App\Models\TipoMusculo;

class EjercicioController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/ejercicios",
     *      operationId="indexEjercicios",
     *      tags={"Ejercicios"},
     *      summary="Listar ejecicios",
     *      description="Lista todos los ejercicios, solo admin y entrenadores tienen autorización",
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
    public function index(IndexEjercicioRequest $request) {
        $ejercicios = Ejercicio::all();

        return new EjercicioCollection($ejercicios->loadMissing(["tipoMusculo", "series", "estadisticas"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/ejercicios",
     *      operationId="storeEjercicios",
     *      tags={"Ejercicios"},
     *      summary="Crear un ejercicio",
     *      description="Crea un nuevo ejercicio, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"nombre", "descripcion", "id_tipo_musculo"},
     *              @OA\Property(property="nombre", type="string", example="Sentadilla normal y corriente"),
     *              @OA\Property(property="descripcion", type="string", example="Crecerá tu pierna"),
     *              @OA\Property(property="id_tipo_musculo", type="integer", example=1)
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
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function store(StoreEjercicioRequest $request) {
        $tipoMusculo = TipoMusculo::find($request->id_tipo_musculo);

        if (!$tipoMusculo) {
            return response("El tipo de músuculo indicado no existe", 205);
        }

        $ejercicio = new Ejercicio($request->all());
        $ejercicio->save();

        return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/ejercicios/{id_ejercicio}",
     *      operationId="updateEjercicios",
     *      tags={"Ejercicios"},
     *      summary="Actualiza un ejercicio",
     *      description="Actualiza un ejercicio, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_ejercicio",
     *          description="ID del ejercicio",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="nombre", type="string", example="Sentadilla normal y corriente"),
     *              @OA\Property(property="descripcion", type="string", example="Crecerá tu pierna"),
     *              @OA\Property(property="id_tipo_musculo", type="integer", example=1)
     *          )
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
     *          description="Algún parámetro inválido o no existe el ejercicio"
     *      )
     * )
     */
    public function update(UpdateEjercicioRequest $request, $ejercicioId) {
        if ($request->id_tipo_musculo) {
            $tipoMusculo = TipoMusculo::find($request->id_tipo_musculo);

            if (!$tipoMusculo) {
                return response("El tipo de músuculo indicado no existe", 205);
            }
        }

        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->update($request->all());

            return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/ejercicios/{id_ejercicio}",
     *      operationId="showEjercicios",
     *      tags={"Ejercicios"},
     *      summary="Obtener un ejecicio",
     *      description="Obtiene el ejercicio indicado, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_ejercicio",
     *          description="ID del ejercicio",
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
     *      )
     * )
     */
    public function show(ShowEjercicioRequest $request, $ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            return new EjercicioResource($ejercicio->loadMissing(["tipoMusculo", "series", "estadisticas"]));

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/ejercicios/{id_ejercicio}",
     *      operationId="deleteEjercicios",
     *      tags={"Ejercicios"},
     *      summary="Borrar un ejecicio",
     *      description="Obtiene el ejercicio indicado, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_ejercicio",
     *          description="ID del ejercicio",
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
     *      )
     * )
     */
    public function destroy(DeleteEjercicioRequest $request, $ejercicioId) {
        $ejercicio = Ejercicio::find($ejercicioId);

        if ($ejercicio) {
            $ejercicio->delete();

            return response(true);

        } else {
            return response("No existe el ejercicio indicado", 205);
        }
    }
}
