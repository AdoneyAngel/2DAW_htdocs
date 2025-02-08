<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanEntrenamiento\DeletePlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\DeletePlanTablaEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\IndexPlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\ShowPlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\StorePlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\StorePlanTablaEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\UpdatePlanEntrenamientoRequest;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoCollection;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoResource;
use App\Models\PlanEntrenamiento;
use App\Models\TablaEntrenamiento;
use App\Models\TipoUsuario;
use App\Models\Usuario;

class PlanEntrenamientoController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/planes_entrenamiento",
     *      operationId="indexPlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Listar planes de entrenamiento",
     *      description="Lista todos los planes de entrenamiento, solo admin y entrenadores tienen autorización",
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
    public function index(IndexPlanEntrenamientoRequest $request) {
        $planes = PlanEntrenamiento::all();

        return new PlanEntrenamientoCollection($planes->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/planes_entrenamiento",
     *      operationId="storePlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Crea un plane de entrenamiento",
     *      description="Crea un plan de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"id_entrenador", "id_cliente", "nombre", "fecha_inicio", "fecha_fin"},
     *              @OA\Property(property="id_entrenador", type="integer", example=1),
     *              @OA\Property(property="id_cliente", type="integer", example=2),
     *              @OA\Property(property="nombre", type="string", example="Hay que entrenar"),
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
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido"
     *      )
     * )
     */
    public function store(StorePlanEntrenamientoRequest $request) {
        $cliente = Usuario::find($request->id_cliente);
        $entrenador = Usuario::find($request->id_entrenador);
        $tipoEntrenador = TipoUsuario::where("tipo_usuario", "entrenador")->first();
        $usuario = $request->user();

        if ($request->id_entrenador != $usuario->id_usuario && !Usuario::esAdmin($usuario)) {//Un entrenador no puedo insertar un plan de entrenamiento a otro entrenador
            return AuthController::UnauthorizedError("No puedes insertar un plan de entrenamiento a otro entrenador");
        }

        if (!$cliente) {//Validar que el cliente existe
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if (!$entrenador) {//Validar que entrenador existe
            return response("El entrenador indicado no se encuentra registrado", 205);

        } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
            return response("El entrenador no está registrado como un entrenador del gimnasio", 401);
        }
        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es un cliente", 401);
        }
        if (!Utilities::validarFechas($request->fecha_inicio, $request->fecha_fin)) {
            return response("Las fechas indicadas no son válidas", 205);
        }

        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 205);
                }
            }
        }

        $plan = new PlanEntrenamiento($request->all());
        $plan->save();
        $plan->tablasEntrenamiento()->sync($request->tablas_entrenamiento);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/planes_entrenamiento/{id_plan}",
     *      operationId="updatePlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Actualiza un plane de entrenamiento",
     *      description="Actualiza un plan de entrenamiento, solo admin y entrenadores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="id_entrenador", type="integer", example=1),
     *              @OA\Property(property="id_cliente", type="integer", example=2),
     *              @OA\Property(property="nombre", type="string", example="Hay que entrenar"),
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
     *          description="Sin autorización, debe ser admin o entrenador"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Algún parámetro inválido o plan no encontrado"
     *      )
     * )
     */
    public function update(UpdatePlanEntrenamientoRequest $request, $planId) {
        $tipoEntrenador = TipoUsuario::where("tipo_usuario", "entrenador")->first();
        $tipoAdministrador = TipoUsuario::where("tipo_usuario", "administrador")->first();
        $plan = PlanEntrenamiento::find($planId);
        $usuario = $request->user();

        if (!$this->esPropietario($usuario, $plan)) {//Un entrenador no puede modificar el plan de otro
            return AuthController::UnauthorizedError("No puedes modificar un plan que no es suyo");
        }

        //Comprobaciones
        if ($request->id_cliente) {//Validar que el cliente existe
            $cliente = Usuario::find($request->id_cliente);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 401);
            }
        }
        if ($request->id_entrenador) {//Validar que el entrenador existe
            if ($usuario->id_usuario != $request->id_entrenador && !Usuario::esAdmin($usuario)) {
                return AuthController::UnauthorizedError("No puedes cambiar de entrenador de este plan");
            }

            $entrenador = Usuario::find($request->id_entrenador);

            if (!$entrenador) {
                return response("El entrenador indicado no se encuentra registrado", 205);

            } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
                return response("El entrenador no está registrado como un entrenador del gimnasio", 401);
            }
        }
        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 205);
                }
            }
        }

        if ($plan) {
            //Validar si las fechas son correctas y coherentes
            if ($request->fecha_inicio || $request->fecha_fin) {
                $fechaInicio = $request->fecha_inicio ?? $plan->fecha_inicio;
                $fechaFin = $request->fecha_fin ?? $plan->fecha_fin;

                if (!Utilities::validarFechas($fechaInicio, $fechaFin)) {
                    return response("Las fechas indicadas no son válidas", 205);
                }
            }




            $plan->update($request->all());

            if ($request->tablas_entrenamiento) {
                $plan->tablasEntrenamiento()->sync($request->tablas_entrenamiento);
            }

            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/planes_entrenamiento/{id_plan}",
     *      operationId="showPlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Obtener plane de entrenamiento",
     *      description="Obtiene un plan de entrenamiento, solo admin, el mismo entrenador y el mismo cliente tienen autorización",
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
     *          description="Sin autorización, debe ser admin o el entrenador/cliente del plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="plan no encontrado"
     *      )
     * )
     */
    public function show(ShowPlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);
        $usuario = $request->user();

        //Autenticacion
        if (!$this->validar($usuario, $plan)) {
            return AuthController::UnauthorizedError();
        }
        if (!$this->esPropietario($usuario, $plan) && Usuario::esEntrenador($usuario)) {
            return AuthController::UnauthorizedError("No puede acceder al plan de otro entrenador");
        }

        if ($plan) {
            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/planes_entrenamiento/{id_plan}",
     *      operationId="destroyPlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Borrar plane de entrenamiento",
     *      description="Borra un plan de entrenamiento, solo admin, el mismo entrenador tienen autorización",
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
     *          description="Sin autorización, debe ser admin o el entrenador del plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="plan no encontrado"
     *      )
     * )
     */
    public function destroy(DeletePlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);
        $usuario = $request->user();

        if (!$this->esPropietario($usuario, $plan)) {//El entrenador no puede borrar el plan de otro
            return AuthController::UnauthorizedError("No puede eliminar un plan que no es suyo");
        }

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/planes_entrenamiento/{id_plan}/tablas_entrenamiento",
     *      operationId="añadirTabla-PlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Añade una tabla al plan de entrenamiento",
     *      description="Añade una tabla al plan de entrenamiento indicado, solo admin, el mismo entrenador tienen autorización",
     *      @OA\Parameter(
     *          name="id_plan",
     *          description="ID del plan",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"id_tabla"},
     *              @OA\Property(property="id_tabla", type="integer", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o el entrenador del plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="plan/tabla no encontrada"
     *      )
     * )
     */
    public function añadirTabla(StorePlanTablaEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $plan->tablasEntrenamiento()->attach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/planes_entrenamiento/{id_plan}/tablas_entrenamiento",
     *      operationId="eliminarTabla-PlanesEntrenamiento",
     *      tags={"Planes_entrenamiento"},
     *      summary="Elimina una tabla al plan de entrenamiento",
     *      description="Eilmina una tabla al plan de entrenamiento indicado, solo admin, el mismo entrenador tienen autorización",
     *      @OA\Parameter(
     *          name="id_plan",
     *          description="ID del plan",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"id_tabla"},
     *              @OA\Property(property="id_tabla", type="integer", example=1),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Sin autorización, debe ser admin o el entrenador del plan"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="plan/tabla no encontrada"
     *      )
     * )
     */
    public function eliminarTabla(DeletePlanTablaEntrenamientoRequest $request, $id_plan) {
        $plan = PlanEntrenamiento::find($id_plan);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $plan->tablasEntrenamiento()->detach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    private function validar(Usuario $usuario, PlanEntrenamiento $plan) {
        if (($usuario->id_usuario != $plan->id_cliente) && !Usuario::esEntrenador($usuario) && !Usuario::esAdmin($usuario)) {//Si no es gestor ni admin no está autorizado
            return false;
        }

        return true;
    }

    private function esPropietario(Usuario $entrenador, PlanEntrenamiento $plan) {
        if (($entrenador->id_usuario != $plan->id_entrenador) && !Usuario::esAdmin($entrenador)) {//Si no es gestor ni admin no está autorizado
            return false;
        }

        return true;
    }
}
