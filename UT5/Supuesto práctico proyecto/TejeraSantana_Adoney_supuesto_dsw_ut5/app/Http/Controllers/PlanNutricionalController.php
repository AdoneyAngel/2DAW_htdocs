<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanNutricional\DeletePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\IndexPLanNutricionalRequest;
use App\Http\Requests\PlanNutricional\ShowPLanNutricionalRequest;
use App\Http\Requests\PlanNutricional\StorePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\UpdatePlanNutricionalRequest;
use App\Http\Resources\PlanNutricional\PlanNutricionalCollection;
use App\Http\Resources\PlanNutricional\PlanNutricionalResource;
use App\Models\PlanNutricional;
use App\Models\Usuario;

class PlanNutricionalController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/planes_nutricionales",
     *      operationId="indexPlanesNutricionales",
     *      tags={"Planes_nutricionales"},
     *      summary="Listar planes nutricionales",
     *      description="Lista todos los planes nutricionales, solo admin y nutricionistas tienen autorización",
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o nutricionista"
     *      )
     * )
     */
    public function index(IndexPLanNutricionalRequest $request) {
        $planes = PlanNutricional::all();

        return new PlanNutricionalCollection($planes->loadMissing(["cliente", "nutricionista"]));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/planes_nutricionales",
     *      operationId="storePlanesNutricionales",
     *      tags={"Planes_nutricionales"},
     *      summary="Crear plan nutricional",
     *      description="Crea un plan nutricional, solo admin y nutricionistas (solo puede crear su propio plan) tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"id_nutricionista", "id_cliente", "nombre", "recomendaciones_dieta", "porcentaje_carbohidratos", "porcentaje_proteinas", "porcentaje_grasas", "porcentaje_fibra", "fecha_inicio", "fecha_fin"},
     *              @OA\Property(property="id_nutricionista", type="integer", example=1),
     *              @OA\Property(property="id_cliente", type="integer", example=2),
     *              @OA\Property(property="nombre", type="string", example="Hay que comer"),
     *              @OA\Property(property="recomendaciones_dieta", type="string", example="Hay que comer mas"),
     *              @OA\Property(property="porcentaje_carbohidratos", type="float", example=40),
     *              @OA\Property(property="porcentaje_proteinas", type="float", example=40),
     *              @OA\Property(property="porcentaje_grasas", type="float", example=40),
     *              @OA\Property(property="porcentaje_fibra", type="float", example=40),
     *              @OA\Property(property="fecha_inicio", type="date", example="2025-2-8"),
     *              @OA\Property(property="fecha_fin", type="date", example="2054-3-12"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o nutricionista y que sea su propio plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function store(StorePlanNutricionalRequest $request) {
        $cliente = Usuario::find($request->id_cliente);
        $nutricionista = Usuario::find($request->id_nutricionista);
        $usuario = $request->user();


        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);

        }
        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 205);

        }
        if (!$nutricionista) {
            return response("El nutricionistsa indicado no se encuentra registrado", 205);

        }
        if (!Usuario::esNutricionista($nutricionista)) {
            return response("El usuario indicado no es un nutricionista", 205);

        }
        if (!Utilities::validarFechas($request->fecha_inicio, $request->fecha_fin)) {
            return response("Las fechas introducidas no son correctas", 205);

        }
        if ($nutricionista->id_usuario != $usuario->id_usuario) {
            return AuthController::UnauthorizedError("No puede crear un plan para otro nutricionista");
        }

        $plan = new PlanNutricional($request->all());
        $plan->save();

        return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/planes_nutricionales/{id_plan}",
     *      operationId="updatePlanesNutricionales",
     *      tags={"Planes_nutricionales"},
     *      summary="Actualizar plan nutricional",
     *      description="Actualiza un plan nutricional, solo admin y nutricionistas (solo puede con su propio plan) tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="id_nutricionista", type="integer", example=1),
     *              @OA\Property(property="id_cliente", type="integer", example=2),
     *              @OA\Property(property="nombre", type="string", example="Hay que comer"),
     *              @OA\Property(property="recomendaciones_dieta", type="string", example="Hay que comer mas"),
     *              @OA\Property(property="porcentaje_carbohidratos", type="float", example=40),
     *              @OA\Property(property="porcentaje_proteinas", type="float", example=40),
     *              @OA\Property(property="porcentaje_grasas", type="float", example=40),
     *              @OA\Property(property="porcentaje_fibra", type="float", example=40),
     *              @OA\Property(property="fecha_inicio", type="date", example="2025-2-8"),
     *              @OA\Property(property="fecha_fin", type="date", example="2054-3-12"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_plan",
     *          description="ID del plan",
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
     *          description="Sin autorización, debe ser admin o nutricionista y que sea su propio plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o no se encuentra el plan"
     *      )
     * )
     */
    public function update(UpdatePlanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);

        $usuario = $request->user();
        $cliente = Usuario::find($request->id_cliente);
        $nutricionista = Usuario::find($request->id_nutricionista);
        $plan = PlanNutricional::find($planId);

        //Comprobaciones
        if (!$plan) {
            return response("El plan introducido no se encuentra registrado", 205);
        }
        if($request->id_cliente) {
            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 205);
            }
        }
        if ($request->id_nutricionista) {
            if (!$nutricionista) {
                return response("El nutricionistsa indicado no se encuentra registrado", 205);

            } else if (!Usuario::esNutricionista($nutricionista)) {
                return response("El usuario indicado no es un nutricionista", 205);
            }
        }
        if (!$this->esPropietario($usuario, $plan)) {//Si el usuario no es admin, deberá ser el nutricionista de este cliente
            return AuthController::UnauthorizedError("No tiene autorización para modificar un plan de un cliente que no es suyo");
        }

        //Validar si las fechas son coherentes
        if ($request->fecha_inicio || $request->fecha_fin) {
            $fechaInicio = $request->fecha_inicio ?? $plan->fecha_inicio;
            $fechaFin = $request->fecha_fin ?? $plan->fecha_fin;

            if (!Utilities::validarFechas($fechaInicio, $fechaFin)) {
                return response("Las fechas indicadas no son válidas", 205);
            }
        }


        $plan->update($request->all());

        return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/planes_nutricionales/{id_plan}",
     *      operationId="showPlanesNutricionales",
     *      tags={"Planes_nutricionales"},
     *      summary="Obtener plan nutricional",
     *      description="Obtiene un plan nutricional, solo admin y nutricionistas (solo puede con su propio plan) tienen autorización",
     *      @OA\Parameter(
     *          name="id_plan",
     *          description="ID del plan",
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
     *          description="Sin autorización, debe ser admin, nutricionista, si es su propio plan, o el cliente del plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o no se encuentra el plan"
     *      )
     * )
     */
    public function show(ShowPLanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);
        $usuario = $request->user();

        if (!$plan) {
            return response("El plan introducido no se encuentra registrado", 205);
        }

        if (!$this->validar($usuario, $plan)) {
            return AuthController::UnauthorizedError("No puedes acceder a un plan que no le pertenece");
        }
        if (!$this->esPropietario($usuario, $plan) && Usuario::esNutricionista($usuario)) {
            return AuthController::UnauthorizedError("No puede acceder a un plan de otro nutricionistas");
        }

        return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/planes_nutricionales/{id_plan}",
     *      operationId="destroyPlanesNutricionales",
     *      tags={"Planes_nutricionales"},
     *      summary="Borrar plan nutricional",
     *      description="Borra un plan nutricional, solo admin y nutricionistas (solo puede con su propio plan) tienen autorización",
     *      @OA\Parameter(
     *          name="id_plan",
     *          description="ID del plan",
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
     *          description="Sin autorización, debe ser admin o nutricionista y que sea su propio plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o no se encuentra el plan"
     *      )
     * )
     */
    public function destroy(DeletePlanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);
        $usuario = $request->user();

        if (!$plan) {
            return response("El plan introducido no se encuentra registrado", 205);
        }

        if (!$this->esPropietario($usuario, $plan)) {
            return AuthController::UnauthorizedError("No puede borrar un plan de otro nutricionista");
        }

        $plan->delete();

        return response(true);
    }

    private function validar(Usuario $usuario, PlanNutricional $plan) {
        if (($usuario->id_usuario != $plan->id_cliente) && !Usuario::esNutricionista($usuario) && !Usuario::esAdmin($usuario)) {//Si no es nutricionista ni admin ni cliente no está autorizado
            return false;
        }

        return true;
    }
    private function esPropietario(Usuario $nutricionista, PlanNutricional $plan) {
        if (($nutricionista->id_usuario != $plan->id_nutricionista) && !Usuario::esAdmin($nutricionista)) {//Si no es nutricionista ni admin ni cliente no está autorizado
            return false;
        }

        return true;
    }
}
