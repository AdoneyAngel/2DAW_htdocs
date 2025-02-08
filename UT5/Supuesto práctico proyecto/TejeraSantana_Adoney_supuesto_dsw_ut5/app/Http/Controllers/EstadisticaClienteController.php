<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaCliente\DeleteEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\IndexEstadisticaclienteRequest;
use App\Http\Requests\EstadisticaCliente\ShowEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\StoreEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\UpdateEstadisticaClienteRequest;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteCollection;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteResource;
use App\Models\EstadisticaCliente;
use App\Models\Usuario;

class EstadisticaClienteController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/estadisticas_cliente",
     *      operationId="indexEstadisticasCliente",
     *      tags={"Estadisticas_cliente"},
     *      summary="Listar estadísticas de cliente",
     *      description="Lista todas las estadísticas de clientes, solo admin y gestores tienen autorización",
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
    public function index(IndexEstadisticaClienteRequest $request) {
        $estadisticas = EstadisticaCliente::all();

        return new EstadisticaClienteCollection($estadisticas->loadMissing("cliente"));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/estadisticas_cliente",
     *      operationId="storeEstadisticasCliente",
     *      tags={"Estadisticas_cliente"},
     *      summary="Crea una estadistica de cliente",
     *      description="Crea una estadística de un cliente, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"peso", "altura", "grasa_corporal", "cintura", "pecho", "pierna", "biceps", "triceps", "id_cliente"},
     *              @OA\Property(property="peso", type="float", example=1.8),
     *              @OA\Property(property="grasa_corporal", type="float", example=1.8),
     *              @OA\Property(property="altura", type="float", example=10),
     *              @OA\Property(property="cintura", type="float", example=10),
     *              @OA\Property(property="pecho", type="float", example=10),
     *              @OA\Property(property="pierna", type="float", example=10),
     *              @OA\Property(property="biceps", type="float", example=10),
     *              @OA\Property(property="triceps", type="float", example=10),
     *              @OA\Property(property="id_cliente", type="integer", example=1),
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
     *          description="Parámetro inválido"
     *      )
     * )
     */
    public function store(StoreEstadisticaClienteRequest $request) {
        $cliente = Usuario::find($request->id_cliente);

        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if(!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 205);
        }
        if ($request->peso <= 0) {
            return response("El peso no es válido", 205);
        }
        if ($request->altura <= 0) {
            return response("La altura no es válido", 205);
        }
        if ($request->grasa_corporal <= 0) {
            return response("La grasa corporal no es válido", 205);
        }
        if ($request->cintura <= 0) {
            return response("La cintura no es válido", 205);
        }
        if ($request->pecho <= 0) {
            return response("El pecho no es válido", 205);
        }
        if ($request->pierna <= 0) {
            return response("La pierna no es válido", 205);
        }
        if ($request->biceps <= 0) {
            return response("El biceps no es válido", 205);
        }
        if ($request->triceps <= 0) {
            return response("Los triceps no es válido", 205);
        }

        $estadistica = new EstadisticaCliente($request->all());
        $estadistica->save();

        return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/estadisticas_cliente/{id_estadistica}",
     *      operationId="putEstadisticasCliente",
     *      tags={"Estadisticas_cliente"},
     *      summary="Actualiza una estadistica de cliente",
     *      description="Actualiza una estadística de un cliente, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="peso", type="float", example=1.8),
     *              @OA\Property(property="grasa_corporal", type="float", example=1.8),
     *              @OA\Property(property="altura", type="float", example=10),
     *              @OA\Property(property="cintura", type="float", example=10),
     *              @OA\Property(property="pecho", type="float", example=10),
     *              @OA\Property(property="pierna", type="float", example=10),
     *              @OA\Property(property="biceps", type="float", example=10),
     *              @OA\Property(property="triceps", type="float", example=10),
     *              @OA\Property(property="id_cliente", type="integer", example=1),
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
     *          description="Sin autorización, debe ser admin o gestor"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="Parámetro inválido o no se encuentra la estadistica"
     *      )
     * )
     */
    public function update(UpdateEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        //Comprobaciones
        if ($request->id_cliente) {

            $cliente = Usuario::find($request->id_cliente);

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 401);
            }
            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }
        }

        if (is_numeric($request->peso) && $request->peso <= 0) {
            return response("El peso no es válido", 205);
        }
        if (is_numeric($request->altura) && $request->altura <= 0) {
            return response("La altura no es válido", 205);
        }
        if (is_numeric($request->grasa_corporal) && $request->grasa_corporal <= 0) {
            return response("La grasa corporal no es válido", 205);
        }
        if (is_numeric($request->cintura) && $request->cintura <= 0) {
            return response("La cintura no es válido", 205);
        }
        if (is_numeric($request->pecho) && $request->pecho <= 0) {
            return response("El pecho no es válido", 205);
        }
        if (is_numeric($request->pierna) && $request->pierna <= 0) {
            return response("La pierna no es válido", 205);
        }
        if (is_numeric($request->biceps) && $request->biceps <= 0) {
            return response("El biceps no es válido", 205);
        }
        if (is_numeric($request->triceps) && $request->triceps <= 0) {
            return response("Los triceps no es válido", 205);
        }

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/estadisticas_cliente/{id_estadistica}",
     *      operationId="showEstadisticasCliente",
     *      tags={"Estadisticas_cliente"},
     *      summary="Obtiene la estadistica de un cliente",
     *      description="Obtiene la estadística de un cliente, solo admin, gestores y el mismo cliente tienen autorización",
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
     *          description="Sin autorización, debe ser admin, gestor o el mismo cliente"
     *      )
     * )
     */
    public function show(ShowEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);
        $usuario = $request->user();

        //Autenticacion
        if (!$this->validar($usuario, $estadistica)) {
            return AuthController::UnauthorizedError();
        }

        if ($estadistica) {
            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/estadisticas_cliente/{id_estadistica}",
     *      operationId="deleteEstadisticasCliente",
     *      tags={"Estadisticas_cliente"},
     *      summary="Borra la estadistica de un cliente",
     *      description="Borra la estadística de un cliente, solo admin y gestores tienen autorización",
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
     *          description="Sin autorización, debe ser admin, gestor o el mismo cliente"
     *      ),
     *      @OA\Response(
     *          response=205,
     *          description="No existen las estadísticas"
     *      )
     * )
     */
    public function destroy(DeleteEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadísticas indicadas", 205);
        }
    }

    private function validar(Usuario $usuario, EstadisticaCliente $estadistica) {//Valida si el usuario es admin, gestor o propietario
        if (($usuario->id_usuario != $estadistica->id_cliente) && !Usuario::esAdmin($usuario) && !Usuario::esGestor($usuario)) {
            return false;
        }

        return true;
    }
}
