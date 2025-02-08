<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suscripcion\DeleteSuscripcionRequest;
use App\Http\Requests\Suscripcion\IndexSuscripcionRequest;
use App\Http\Requests\Suscripcion\ShowSuscripcionRequest;
use App\Http\Requests\Suscripcion\StoreSuscripcionRequest;
use App\Http\Requests\Suscripcion\UpdateSuscripcionRequest;
use App\Http\Resources\Suscripcion\SuscripcionCollection;
use App\Http\Resources\Suscripcion\SuscripcionResource;
use App\Models\Suscripcion;
use App\Models\Usuario;

class SuscripcionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/adoneytj/suscripciones",
     *      operationId="indexSuscripciones",
     *      tags={"Suscripciones"},
     *      summary="Listar suscripciones",
     *      description="Lista todas las suscripciones, solo admin y gestores tienen autorización",
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
    public function index(IndexSuscripcionRequest $request) {
        $suscripciones = Suscripcion::all();

        return new SuscripcionCollection($suscripciones->loadMissing("cliente"));
    }

    /**
     * @OA\Post(
     *      path="/api/adoneytj/suscripciones",
     *      operationId="storeSuscripciones",
     *      tags={"Suscripciones"},
     *      summary="Crear una suscripcion",
     *      description="Crea una suscripcion, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"tipo_suscripcion", "precio", "dias", "fecha_inicio", "fecha_fin", "id_cliente"},
     *              @OA\Property(property="tipo_suscripcion", type="string", example="Semanal"),
     *              @OA\Property(property="precio", type="float", example=50.2),
     *              @OA\Property(property="dias", type="integer", example=34),
     *              @OA\Property(property="fecha_inicio", type="date", example="2025-1-3"),
     *              @OA\Property(property="fecha_fin", type="date", example="2025-4-3"),
     *              @OA\Property(property="id_cliente", type="integer", example=3),
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
     *          description="Algún parámetro inválido o cliente inexistente"
     *      )
     * )
     */
    public function store(StoreSuscripcionRequest $request) {
        $cliente = Usuario::find($request->id_cliente);

        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 401);
        }
        if (!Utilities::validarFechas($request->fecha_inicio, $request->fecha_fin)) {
            return response("Las fechas indicadas no son válidas", 205);
        }

        $nuevaSuscripcion = new Suscripcion($request->all());
        $nuevaSuscripcion->save();

        return new SuscripcionResource($nuevaSuscripcion->loadMissing("cliente"));
    }

    /**
     * @OA\Put(
     *      path="/api/adoneytj/suscripciones/{id_suscripcion}",
     *      operationId="updateSuscripciones",
     *      tags={"Suscripciones"},
     *      summary="Actualizar suscripcion",
     *      description="Actualiza una suscripcion, solo admin y gestores tienen autorización",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="tipo_suscripcion", type="string", example="Semanal"),
     *              @OA\Property(property="precio", type="float", example=50.2),
     *              @OA\Property(property="dias", type="integer", example=34),
     *              @OA\Property(property="fecha_inicio", type="date", example="2025-1-3"),
     *              @OA\Property(property="fecha_fin", type="date", example="2025-4-3"),
     *              @OA\Property(property="id_cliente", type="integer", example=3),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id_suscripcion",
     *          description="ID de la suscripcion",
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
     *          description="Algún parámetro inválido, cliente inexistente o suscripción no encontrada"
     *      )
     * )
     */
    public function update(UpdateSuscripcionRequest $request, $suscripcionId) {
        //Comprobaciones
        if ($request->id_cliente) {
            $cliente = Usuario::find($request->id_cliente);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }
            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 401);
            }
        }

        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            //Validar si las fechas son correctas y coherentes
            if ($request->fecha_inicio || $request->fecha_fin) {
                $fechaInicio = $request->fecha_inicio ?? $suscripcion->fecha_inicio;
                $fechaFin = $request->fecha_fin ?? $suscripcion->fecha_fin;

                if (!Utilities::validarFechas($fechaInicio, $fechaFin)) {
                    return response("Las fechas indicadas no son válidas", 205);
                }
            }

            $suscripcion->update($request->all());

            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/adoneytj/suscripciones/{id_suscripcion}",
     *      operationId="showSuscripciones",
     *      tags={"Suscripciones"},
     *      summary="Obtener suscripcion",
     *      description="Obtiene la suscripcion indicada, solo admin, gestores y el mismo cliente tienen autorización",
     *      @OA\Parameter(
     *          name="id_suscripcion",
     *          description="ID de la suscripcion",
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
     *          description="Suscripción no encontrada"
     *      )
     * )
     */
    public function show(ShowSuscripcionRequest $request, $suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);
        $usuario = $request->user();

        if (!$this->validar($usuario, $suscripcion)) {
            return AuthController::UnauthorizedError("No puedes acceder a una suscripcion de otro usuario");
        }

        if ($suscripcion) {
            return new SuscripcionResource($suscripcion->loadMissing("cliente"));

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/adoneytj/suscripciones/{id_suscripcion}",
     *      operationId="destroySuscripciones",
     *      tags={"Suscripciones"},
     *      summary="Borrar suscripcion",
     *      description="Borra la suscripcion indicada, solo admin y gestores tienen autorización",
     *      @OA\Parameter(
     *          name="id_suscripcion",
     *          description="ID de la serie",
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
     *          description="Suscripción no encontrada"
     *      )
     * )
     */
    public function destroy(DeleteSuscripcionRequest $request, $suscripcionId) {
        $suscripcion = Suscripcion::find($suscripcionId);

        if ($suscripcion) {
            $suscripcion->delete();

            return response(true);

        } else {
            return response("No existe la suscripción indicada", 205);
        }
    }

    private function validar(Usuario $usuario, Suscripcion $suscripcion) {
        if (($usuario->id_usuario != $suscripcion->id_cliente) && !Usuario::esGestor($usuario) && !Usuario::esAdmin($usuario)) {//Si no es gestor ni admin ni cliente no está autorizado
            return false;
        }

        return true;
    }
}
