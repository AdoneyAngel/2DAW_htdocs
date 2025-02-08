<?php

namespace App\Http\Controllers;

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
    public function index(IndexSuscripcionRequest $request) {
        $suscripciones = Suscripcion::all();

        return new SuscripcionCollection($suscripciones->loadMissing("cliente"));
    }

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

    public function destroy($suscripcionId) {
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
