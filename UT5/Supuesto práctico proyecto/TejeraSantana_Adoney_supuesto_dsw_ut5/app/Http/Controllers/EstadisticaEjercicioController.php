<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaEjercicio\DeleteEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\IndexEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\StoreEstadisticaEjercicioRequest;
use App\Http\Requests\EstadisticaEjercicio\UpdateEstadisticaEjercicioRequest;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioCollection;
use App\Http\Resources\EstadisticaEjercicio\EstadisticaEjercicioResource;
use App\Models\Ejercicio;
use App\Models\EstadisticaEjercicio;
use DateTime;

class EstadisticaEjercicioController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/estadisticas_ejercicio",
     *      operationId="indexEstadisticasEjercicio",
     *      tags={"Estadisticas_ejercicio"},
     *      summary="Listar estadísticas de ejercicio",
     *      description="Lista todas las estadísticas de ejercicios, solo admin y entrenadores tienen autorización",
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
    public function index(IndexEstadisticaEjercicioRequest $request) {
        $estadisticas = EstadisticaEjercicio::all();

        return new EstadisticaEjercicioCollection($estadisticas->loadMissing(["ejercicio"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/estadisticas_ejercicio",
     *      operationId="storeEstadisticasEjercicio",
     *      tags={"Estadisticas_ejercicio"},
     *      summary="Crea una estadística de ejercicio",
     *      description="Crea una estadística de ejercicio, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"num_sesiones", "tiempo_total", "duracion_media", "sets_completados", "volumen_total", "repeticiones_totales", "fecha_entrenamiento"},
     *              @OA\Property(property="num_sesiones", type="integer", example=15),
     *              @OA\Property(property="tiempo_total", type="integer", example=18),
     *              @OA\Property(property="duracion_media", type="integer", example=10),
     *              @OA\Property(property="sets_completados", type="integer", example=3),
     *              @OA\Property(property="volumen_total", type="integer", example=1),
     *              @OA\Property(property="repeticiones_totales", type="integer", example=153),
     *              @OA\Property(property="fecha_entrenamiento", type="date", example="1433-4-13"),
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
    public function store(StoreEstadisticaEjercicioRequest $request) {
        $ejercicio = Ejercicio::find($request->id_ejercicio);

        //Comprobaciones
        if (!$ejercicio) {
            return response("No se ha podido encontrar el ejercicio indicado", 205);
        }
        if ($request->num_sesiones <= 0) {
            return response("El número de sesiones no es válido", 205);
        }
        if ($request->tiempo_total <= 0) {
            return response("El tiempo total no es válido", 205);
        }
        if ($request->duracion_media <= 0) {
            return response("La duración media no es válida", 205);
        }
        if ($request->sets_completados < 0) {
            return response("Los sets_completados no son válidos", 205);
        }
        if ($request->volumen_total < 0) {
            return response("El volumen total no es válido", 205);
        }
        if ($request->repeticiones_totales < 0) {
            return response("Las repeticiones totales no son válidos", 205);
        }
        if (new DateTime($request->fecha_entrenamiento) > new DateTime("now")) {
            return response("La fecha de entrenamiento no es válido", 205);
        }

        $estadistica = new EstadisticaEjercicio($request->all());
        $estadistica->save();

        return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/estadisticas_ejercicio/{id_estadistica}",
     *      operationId="updateEstadisticasEjercicio",
     *      tags={"Estadisticas_ejercicio"},
     *      summary="Actualiza una estadística de ejercicio",
     *      description="Actualiza una estadística de ejercicio, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="num_sesiones", type="integer", example=15),
     *              @OA\Property(property="tiempo_total", type="integer", example=18),
     *              @OA\Property(property="duracion_media", type="integer", example=10),
     *              @OA\Property(property="sets_completados", type="integer", example=3),
     *              @OA\Property(property="volumen_total", type="integer", example=1),
     *              @OA\Property(property="repeticiones_totales", type="integer", example=153),
     *              @OA\Property(property="fecha_entrenamiento", type="date", example="1433-4-13"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_estadistica",
     *          description="ID de la estadisticas",
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
     *          description="Algún parámetro inválido o no existe la estadística"
     *      )
     * )
     */
    public function update(UpdateEstadisticaEjercicioRequest $request, $estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        //Comprobaciones
        if ($request->id_ejercicio) {
            $ejercicio = Ejercicio::find($request->id_ejercicio);

            if (!$ejercicio) {
                return response("No se ha podido encontrar el ejercicio indicado", 205);
            }

        }
        if (!$ejercicio) {
            return response("No se ha podido encontrar el ejercicio indicado", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->num_sesiones <= 0) {
            return response("El número de sesiones no es válido", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->tiempo_total <= 0) {
            return response("El tiempo total no es válido", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->duracion_media <= 0) {
            return response("La duración media no es válida", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->sets_completados < 0) {
            return response("Los sets_completados no son válidos", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->volumen_total < 0) {
            return response("El volumen total no es válido", 205);
        }
        if (is_numeric($request->num_sesiones) && $request->repeticiones_totales < 0) {
            return response("Las repeticiones totales no son válidos", 205);
        }
        if (is_numeric($request->fecha_entrenamiento) && (new DateTime($request->fecha_entrenamiento) > new DateTime("now"))) {
            return response("La fecha de entrenamiento no es válido", 205);
        }

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/estadisticas_ejercicio/{id_ejercicio}",
     *      operationId="showEstadisticasEjercicio",
     *      tags={"Estadisticas_ejercicio"},
     *      summary="Obtiene la estadistica de un ejercicio",
     *      description="Obtiene la estadística de un ejercicios, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_estadistica",
     *          description="ID de la estadisticas",
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
     *          description="No se ha encontrado la estadistica"
     *      )
     * )
     */
    public function show($estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            return new EstadisticaEjercicioResource($estadistica->loadMissing(["ejercicio"]));

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/estadisticas_ejercicio/{id_ejercicio}",
     *      operationId="destroyEstadisticasEjercicio",
     *      tags={"Estadisticas_ejercicio"},
     *      summary="Borra la estadistica de un ejercicio",
     *      description="Borra la estadística de un ejercicios, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_estadistica",
     *          description="ID de la estadisticas",
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
     *          description="No se ha encontrado la estadistica"
     *      )
     * )
     */
    public function destroy(DeleteEstadisticaEjercicioRequest $request, $estadisticaId) {
        $estadistica = EstadisticaEjercicio::find($estadisticaId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadistica indicada", 205);
        }
    }
}
