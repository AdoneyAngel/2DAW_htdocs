<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanNutricional\DeletePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\StorePlanNutricionalRequest;
use App\Http\Requests\PlanNutricional\UpdatePlanNutricionalRequest;
use App\Http\Resources\PlanNutricional\PlanNutricionalCollection;
use App\Http\Resources\PlanNutricional\PlanNutricionalResource;
use App\Models\PlanNutricional;

class PlanNutricionalController extends Controller
{
    public function index() {
        $planes = PlanNutricional::all();

        return new PlanNutricionalCollection($planes->loadMissing(["cliente", "nutricionista"]));
    }

    public function store(StorePlanNutricionalRequest $request) {
        $plan = new PlanNutricional($request->all());
        $plan->save();

        return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));
    }

    public function update(UpdatePlanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);

        if ($plan) {
            $plan->update($request->all());

            return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));

        } else {
            return response("No existe el plan indicado", 404);
        }
    }

    public function show($planId) {
        $plan = PlanNutricional::find($planId);

        if ($plan) {
            return new PlanNutricionalResource($plan->loadMissing("cliente")->loadMissing("nutricionista"));

        } else {
            return response("No existe el plan indicado", 404);
        }
    }

    public function destroy(DeletePlanNutricionalRequest $request, $planId) {
        $plan = PlanNutricional::find($planId);

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 404);
        }
    }
}
