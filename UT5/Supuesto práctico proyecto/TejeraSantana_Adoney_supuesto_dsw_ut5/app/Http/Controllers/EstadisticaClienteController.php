<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadisticaCliente\DeleteEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\StoreEstadisticaClienteRequest;
use App\Http\Requests\EstadisticaCliente\UpdateEstadisticaClienteRequest;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteCollection;
use App\Http\Resources\EstadisticaCliente\EstadisticaClienteResource;
use App\Models\EstadisticaCliente;
use App\Models\Usuario;

class EstadisticaClienteController extends Controller
{
    public function index() {
        $estadisticas = EstadisticaCliente::all();

        return new EstadisticaClienteCollection($estadisticas->loadMissing("cliente"));
    }

    public function store(StoreEstadisticaClienteRequest $request) {
        $cliente = Usuario::find($request->id_cliente);

        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 404);
        }
        if(!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 406);
        }

        $estadistica = new EstadisticaCliente($request->all());
        $estadistica->save();

        return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));
    }

    public function update(UpdateEstadisticaClienteRequest $request, $estadisticaClienteId) {
        //Comprobaciones
        if ($request->id_cliente) {
            $cliente = Usuario::find($request->id_cliente);

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 406);
            }
            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 404);
            }
        }

        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->update($request->all());

            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 404);
        }
    }

    public function show($estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            return new EstadisticaClienteResource($estadistica->loadMissing("cliente"));

        } else {
            return response("No existe las estadísticas indicadas", 404);
        }
    }

    public function destroy(DeleteEstadisticaClienteRequest $request, $estadisticaClienteId) {
        $estadistica = EstadisticaCliente::find($estadisticaClienteId);

        if ($estadistica) {
            $estadistica->delete();

            return response(true);

        } else {
            return response("No existe las estadísticas indicadas", 404);
        }
    }
}
