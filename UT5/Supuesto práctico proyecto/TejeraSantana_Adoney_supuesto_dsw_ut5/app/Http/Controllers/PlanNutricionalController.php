<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanNutricional\DeletePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\StorePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\UpdatePlanNutricionalRequest;
use App\Http\Resources\PlanNutricional\PlanNutricionalCollection;
use App\Http\Resources\PlanNutricional\PlanNutricionalResource;
use App\Models\PlanNutricional;
use App\Models\TipoUsuario;
use App\Models\Usuario;

class PlanNutricionalController extends Controller
{
    public function index() {
        $planes = PlanNutricional::all();

        return new PlanNutricionalCollection($planes->loadMissing(["cliente", "nutricionista"]));
    }

    public function store(StorePlanNutricionalRequest $request) {
        $cliente = Usuario::find($request->id_cliente);
        $nutricionista = Usuario::find($request->id_nutricionista);
        $tipoNutricionista = TipoUsuario::where("tipo_usuario", "nutricionista")->first();

        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }

        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es cliente", 401);
        }

        if (!$nutricionista) {
            return response("El nutricionistsa indicado no se encuentra registrado", 205);

        } else if ($nutricionista->tipoUsuario->id_tipo_usuario != $tipoNutricionista->id_tipo_usuario) {
            return response("El usuario indicado no es un nutricionista", 401);
        }

        $plan = new PlanNutricional($request->all());
        $plan->save();

        return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));
    }

    public function update(UpdatePlanNutricionalRequest $request, $planId) {
        $cliente = Usuario::find($request->id_cliente);
        $nutricionista = Usuario::find($request->id_nutricionista);
        $tipoNutricionista = TipoUsuario::where("tipo_usuario", "nutricionista")->first();

        if($request->id_cliente) {
            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es cliente", 401);
            }
        }

        if ($request->id_nutricionista) {
            if (!$nutricionista) {
                return response("El nutricionistsa indicado no se encuentra registrado", 205);

            } else if ($nutricionista->tipoUsuario->id_tipo_usuario != $tipoNutricionista->id_tipo_usuario) {
                return response("El usuario indicado no es un nutricionista", 401);
            }
        }

        $plan = PlanNutricional::find($planId);

        if ($plan) {
            $plan->update($request->all());

            return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    public function show($planId) {
        $plan = PlanNutricional::find($planId);

        if ($plan) {
            return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    public function destroy(DeletePlanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 205);
        }
    }
}
