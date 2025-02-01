<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Http\Resources\Usuario\UsuarioCollection;
use App\Http\Resources\Usuario\UsuarioResource;
use App\Models\TipoUsuario;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index() {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    public function store(StoreUsuarioRequest $request) {
        $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

        if (!$tipoUsuario) {//Validar que el usuario existe
            return response("El tipo de usuario introducido n es válido", 205);
        }

        $nuevoUsuario = new Usuario($request->all());
        $nuevoUsuario->save();

        return new UsuarioResource($nuevoUsuario->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

    public function update(UpdateUsuarioRequest $request, $usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($request->id_tipo_usuario) {//Validar si cambia a un tipo de usuario valido
            $tipoUsuario = TipoUsuario::find($request->id_tipo_usuario);

            if (!$tipoUsuario) {
                return response("El tipo de usuario introducido n es válido", 205);
            }
        }
        if ($request->fecha_registro) {//Validar fecha de registro
            if (!Utilities::validarFechaRegistro($request->fecha_registro)) {
                return response("La fecha de registro no es válido", 205);
            }
        }

        if ($usuario) {//Validar que el usuario existe
            $usuario->update($request->all());

            return new UsuarioResource($usuario->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    public function show($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            return new UsuarioResource($usuario->loadMissing(["planesNutricionales", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    public function destroy($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return response(true);

        } else {
            return response("No existe el usuario indicado", 205);
        }
    }

    public function usuario_info($usuarioId) {
        $usuario = Usuario::find($usuarioId);

        if (!$usuario) {
            return response("El usuario introducido no se ha encontrado", 205);
        }

        $usuario->tablasEntrenamiento();
        $usuario->series();
        $usuario->ejercicios();
        $usuario->entrenadores();
        $usuario->tiposMusculo();
        $usuario->nutricionistas();

        return new UsuarioResource($usuario->loadMissing(["planesEntrenamiento", "planesEntrenamiento", "tipoUsuario", "suscripciones", "estadisticas", "perfil"]));
    }

}
