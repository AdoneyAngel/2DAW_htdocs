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
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if (!$entrenador) {//Validar que entrenador existe
            return response("El entrenador indicado no se encuentra registrado", 205);

        } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
            return response("El entrenador no está registrado como un entrenador del gimnasio", 401);
        }
        if (!Usuario::esCliente($cliente)) {
            return response("El usuario introducido no es un cliente", 401);
        }
        if (!Utilities::validarFechas($request->fecha_inicio, $request->fecha_fin)) {
            return response("Las fechas indicadas no son válidas", 205);
        }

        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 205);
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
        $tipoAdministrador = TipoUsuario::where("tipo_usuario", "administrador")->first();
        $plan = PlanEntrenamiento::find($planId);
        $usuario = $request->user();

        //Comprobaciones
        if ($request->id_cliente) {//Validar que el cliente existe
            $cliente = Usuario::find($request->id_cliente);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 401);
            }
        }
        if ($request->id_entrenador) {//Validar que el entrenador existe
            $entrenador = Usuario::find($request->id_entrenador);

            if (!$entrenador) {
                return response("El entrenador indicado no se encuentra registrado", 205);

            } else if ($entrenador->tipoUsuario->id_tipo_usuario != $tipoEntrenador->id_tipo_usuario) {
                return response("El entrenador no está registrado como un entrenador del gimnasio", 401);
            }
        }
        if ($request->tablas_entrenamiento) {//Validar que las tablas existen
            foreach ($request->tablas_entrenamiento as $tabla) {
                if (!TablaEntrenamiento::find($tabla)) {
                    return response("Una o varias tablas introducidas no existen", 205);
                }
            }
        }
        if ($usuario->tipoUsuario != $tipoAdministrador) {//Validar, si no es administrador, que sea el entrenador del plan
            if ($plan->entrenador->id_usuario != $usuario->id_usuario) {
                return response("No tiene autorización para modificar un plan de un cliente que no es suyo", 403);
            }
        }

        if ($plan) {
            //Validar si las fechas son correctas y coherentes
            if ($request->fecha_inicio || $request->fecha_fin) {
                $fechaInicio = $request->fecha_inicio ?? $plan->fecha_inicio;
                $fechaFin = $request->fecha_fin ?? $plan->fecha_fin;

                if (!Utilities::validarFechas($fechaInicio, $fechaFin)) {
                    return response("Las fechas indicadas no son válidas", 205);
                }
            }




            $plan->update($request->all());

            if ($request->tablas_entrenamiento) {
                $plan->tablasEntrenamiento()->sync($request->tablas_entrenamiento);
            }

            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    public function show($planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    public function destroy(DeletePlanEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);

        if ($plan) {
            $plan->delete();

            return response(true);

        } else {
            return response("No existe el plan indicado", 205);
        }
    }

    public function añadirTabla(StorePlanTablaEntrenamientoRequest $request, $planId) {
        $plan = PlanEntrenamiento::find($planId);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $plan->tablasEntrenamiento()->attach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }

    public function eliminarTabla(DeletePlanTablaEntrenamientoRequest $request, $id_plan) {
        $plan = PlanEntrenamiento::find($id_plan);
        $tabla = TablaEntrenamiento::find($request->id_tabla);

        if (!$plan) {
            return response("No se ha encontrado el plan de entrenamiento indicado", 205);

        } else if (!$tabla) {
            return response("No se ha ha encontrado la tabla de entrenamiento indicado", 205);
        }

        $plan->tablasEntrenamiento()->detach($tabla);

        return new PlanEntrenamientoResource($plan->loadMissing("cliente")->loadMissing("entrenador")->loadMissing("tablasEntrenamiento"));
    }
}
