<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanEntrenamiento\DeletePlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\DeletePlanTablaEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\StorePlanEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\StorePlanTablaEntrenamientoRequest;
use App\Http\Requests\PlanEntrenamiento\UpdatePlanEntrenamientoRequest;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoCollection;
use App\Http\Resources\PlanEntrenamiento\PlanEntrenamientoResource;
use App\Models\PlanEntrenamiento;
use App\Models\TablaEntrenamiento;
use Illuminate\Http\Request;

class PlanEntrenamientoController extends Controller
{

    public function index() {
        $planes = PlanEntrenamiento::all();

        return new PlanEntrenamientoCollection($planes->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function store(StorePlanEntrenamientoRequest $request) {
        $plan = new PlanEntrenamiento($request->all());
        $plan->save();

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function update(UpdatePlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->update($request->all());

            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 404);
        }
    }

    public function show($planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 404);
        }
    }

    public function destroy(DeletePlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 404);
        }
    }

    public function añadirTabla(StorePlanTablaEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 404);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 404);
        }

        $plan->tablasEntrenamiento()->attach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function eliminarTabla(DeletePlanTablaEntrenamientoRequest $request, $id_plan) {
        $plan = PlanEntrenamiento::find($id_plan);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 404);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 404);
        }

        $plan->tablasEntrenamiento()->detach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }
}
