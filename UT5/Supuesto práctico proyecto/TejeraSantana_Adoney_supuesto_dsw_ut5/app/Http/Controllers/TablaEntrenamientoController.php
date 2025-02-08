<?php

namespace App\Http\Controllers;

use App\Http\Requests\TablaEntrenamiento\DeleteTablaEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\DeleteTablaPlanEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\StoreTablaEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\StoreTablaPlanEntrenamientoRequest;
use App\Http\Requests\TablaEntrenamiento\UpdateTablaEntrenamientoRequest;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoCollection;
use App\Http\Resources\TablaEntrenamiento\TablaEntrenamientoResource;
use App\Models\PlanEntrenamiento;
use App\Models\TablaEntrenamiento;

class TablaEntrenamientoController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/tablas_entrenamiento",
     *      operationId="indexTablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Listar tablas de entrenamiento",
     *      description="Lista todas las tablas de entrenamiento, solo admin y entrenadores tienen autorización",
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
        $tablas = TablaEntrenamiento::all();

        return new TablaEntrenamientoCollection($tablas->loadMissing(["planesEntrenamiento", "series"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/tablas_entrenamiento",
     *      operationId="storeTablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Crear tabla de entrenamiento",
     *      description="Crea una tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"semana", "nombre", "num_series", "num_ejercicios", "num_dias"},
     *              @OA\Property(property="semana", type="integer", example=3),
     *              @OA\Property(property="nombre", type="string", example="Tablita"),
     *              @OA\Property(property="num_series", type="integer", example=34),
     *              @OA\Property(property="num_ejercicios", type="integer", example=12),
     *              @OA\Property(property="num_dias", type="integer", example=4)
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
    public function store(StoreTablaEntrenamientoRequest $request) {
        if ($request->planes_entrenamiento) {
            //Validar que todos los planes existen
            foreach($request->planes_entrenamiento as $plan) {
                if (!PlanEntrenamiento::find($plan)) {
                    return response("El/uno de los planes de entrenamiento introducidos no existe", 205);
                }
            }
        }

        $tabla = new TablaEntrenamiento($request->all());
        $tabla->save();

        $tabla->planesEntrenamiento()->sync($request->planes_entrenamiento);

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/tablas_entrenamiento/{id_tabla}",
     *      operationId="updateTablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Actualizar tabla de entrenamiento",
     *      description="Actualizar una tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="semana", type="integer", example=3),
     *              @OA\Property(property="nombre", type="string", example="Tablita"),
     *              @OA\Property(property="num_series", type="integer", example=34),
     *              @OA\Property(property="num_ejercicios", type="integer", example=12),
     *              @OA\Property(property="num_dias", type="integer", example=4)
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tabla",
     *          description="ID de la tabla",
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
     *          description="Algún parámetro inválido o no se encuentra la tabla"
     *      )
     * )
     */
    public function update(UpdateTablaEntrenamientoRequest $request, $tablaId) {
        if ($request->planes_entrenamiento) {
            //Validar que todos los planes existen
            foreach($request->planes_entrenamiento as $plan) {
                if (!PlanEntrenamiento::find($plan)) {
                    return response("El/uno de los planes de entrenamiento introducidos no existe", 205);
                }
            }
        }

        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->update($request->all());

            if ($request->planes_entrenamiento) {
                $tabla->planesEntrenamiento()->sync($request->planes_entrenamiento);
            }

            return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));

        } else {
            return response("No existe la tabla indicada", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/tablas_entrenamiento/{id_tabla}",
     *      operationId="showTablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Obtener tabla de entrenamiento",
     *      description="Obtiene una tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_tabla",
     *          description="ID de la tabla",
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
     *          description="Algún parámetro inválido o no se encuentra la tabla"
     *      )
     * )
     */
    public function show($tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));

        } else {
            return response("No existe la tabla indicada", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/tablas_entrenamiento/{id_tabla}",
     *      operationId="destroyTablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Borrar tabla de entrenamiento",
     *      description="Borra una tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\Parameter(
     *          name="id_tabla",
     *          description="ID de la tabla",
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
     *          description="Algún parámetro inválido o no se encuentra la tabla"
     *      )
     * )
     */
    public function destroy(DeleteTablaEntrenamientoRequest $request, $tablaId) {
        $tabla = TablaEntrenamiento::find($tablaId);

        if ($tabla) {
            $tabla->delete();

            return response(true);

        } else {
            return response("No existe la tabla indicada", 205);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/tablas_entrenamiento/{id_tabla}/planes_entrenamiento",
     *      operationId="postPlan-TablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Añadir plan a tabla de entrenamiento",
     *      description="Añade un plan a la tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              required={"id_plan"},
     *              @OA\Property(property="id_plan", type="integer", example=3),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tabla",
     *          description="ID de la tabla",
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
     *          description="Algún parámetro inválido o no se encuentra la tabla/plan"
     *      )
     * )
     */
    public function añadirPlan(StoreTablaPlanEntrenamientoRequest $request, $tabla_id) {
        $plan = PlanEntrenamiento::find($request->id_plan);
        $tabla = TablaEntrenamiento::find($tabla_id);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $tabla->planesEntrenamiento()->attach($plan);

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/tablas_entrenamiento/{id_tabla}/planes_entrenamiento",
     *      operationId="destroyPlan-TablasEntrenamiento",
     *      tags={"Tablas_entrenamiento"},
     *      summary="Eliminar plan a tabla de entrenamiento",
     *      description="Elimina un plan a la tabla de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              required={"id_plan"},
     *              @OA\Property(property="id_plan", type="integer", example=3),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_tabla",
     *          description="ID de la tabla",
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
     *          description="Algún parámetro inválido o no se encuentra la tabla/plan"
     *      )
     * )
     */
    public function eliminarPlan(DeleteTablaPlanEntrenamientoRequest $request, $tabla_id) {
        $plan = PlanEntrenamiento::find($request->id_plan);
        $tabla = TablaEntrenamiento::find($tabla_id);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $tabla->planesEntrenamiento()->detach($plan);

        return new TablaEntrenamientoResource($tabla->loadMissing(["planesEntrenamiento", "series"]));
    }
}
