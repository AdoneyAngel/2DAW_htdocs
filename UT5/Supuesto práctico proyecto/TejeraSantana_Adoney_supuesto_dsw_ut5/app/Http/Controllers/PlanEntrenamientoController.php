<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanEntrenamiento\StorePlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\UpdatePlanEntrenamientoRequest;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoCollection;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoResource;
use App\Models\PlanEntrenamiento;
use Illuminate\Http\Request;

class PlanEntrenamientoController extends Controller
{

    public function index() {
        $planes = PlanEntrenamiento::all();

        return new PlanEntrenamientoCollection($planes->loadMissing("cliente")->loadMissing("entrenador"));
    }

    public function store(StorePlanEntrenamientoRequest $request) {
        $plan = new PlanEntrenamiento($request->all());
        $plan->save();

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador"));
    }

    public function update(UpdatePlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->update($request->all());

            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador"));

        } else {
            return response("No existe el plan indicado", 500);
        }
    }

    public function show($planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador"));

        } else {
            return response("No existe el plan indicado", 500);
        }
    }

    public function destroy($planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 500);
        }
    }
}
