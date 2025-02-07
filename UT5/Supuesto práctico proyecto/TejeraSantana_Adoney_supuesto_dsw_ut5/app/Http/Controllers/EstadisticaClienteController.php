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
use Illuminate\Support\Facades\Request;

class EstadisticaClienteController extends Controller
{
    public function index(IndexEstadisticaClienteRequest $request) {
        $estadisticas = EstadisticaCliente::all();

        return new EstadisticaClienteCollection($estadisticas->loadMissing("cliente"));
    }

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
