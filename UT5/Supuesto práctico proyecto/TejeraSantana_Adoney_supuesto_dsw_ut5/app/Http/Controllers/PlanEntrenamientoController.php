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
use App\Models\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PlanEntrenamientoController extends Controller
{

    public function index() {
        $planes = PlanEntrenamiento::all();

        return new PlanEntrenamientoCollection($planes->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function store(StorePlanEntrenamientoRequest $request) {
        $cliente = Usuario::find($request->id_cliente);
        $entrenador = Usuario::find($request->id_entrenador);
        $tipoEntrenador = TipoUsuario::where("tipo_usuario", "entrenador")->first();

        if (!$cliente) {//Validar que el cliente existe
            return response("El cliente indicado no se encuentra registrado", 404);
        }
        if (!$entrenador) {//Validar que entrenador existe
            return response("El entrenador indicado no se encuentra registrado", 404);

        } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
            return response("El entrenador no está registrado como un entrenador del gimnasio", 406);
        }

        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es un cliente", 406);
        }

        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 404);
                }
            }
        }

        $plan = new PlanEntrenamiento($request->all());
        $plan->save();
        $plan->tablasEntrenamiento()->sync($request->tablas_entrenamiento);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function update(UpdatePlanEntrenamientoRequest $request, $planId) {
        $tipoEntrenador = TipoUsuario::where("tipo_usuario", "entrenador")->first();

        if ($request->id_cliente) {//Validar que el cliente existe
            $cliente = Usuario::find($request->id_cliente);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 404);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 406);
            }
        }

        if ($request->id_entrenador) {//Validar que el entrenador existe
            $entrenador = Usuario::find($request->id_entrenador);

            if (!$entrenador) {
                return response("El entrenador indicado no se encuentra registrado", 404);

            } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
                return response("El entrenador no está registrado como un entrenador del gimnasio", 406);
            }
        }

        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 404);
                }
            }
        }

        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->update($request->all());

            if ($request->tablas_entrenamiento) {
                $plan->tablasEntrenamiento()->sync($request->tablas_entrenamiento);
            }

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
