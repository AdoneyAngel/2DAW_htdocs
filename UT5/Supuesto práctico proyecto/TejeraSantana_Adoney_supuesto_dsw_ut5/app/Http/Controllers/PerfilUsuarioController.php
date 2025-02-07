<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilUsuario\DeletePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\IndexPerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\ShowPerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\StorePerfilUsuarioRequest;
use App\Http\Requests\PerfilUsuario\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioCollection;
use App\Http\Resources\PerfilUsuario\PerfilUsuarioResource;
use App\Models\PerfilUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    public function index(IndexPerfilUsuarioRequest $request) {
        $perfilesUsuarios = PerfilUsuario::all();

        return new PerfilUsuarioCollection($perfilesUsuarios->loadMissing(["usuario"]));
    }

    public function store(StorePerfilUsuarioRequest $request) {
        $cliente = Usuario::find($request->id_usuario);

        //Comprobaciones
        if (!$cliente) {
            return response("El cliente indicado no se encuentra registrado", 205);
        }
        if ($request->edad < 12) {
            return response("La edad debe ser de al menos 12 años", 205);
        }
        if (!Utilities::validarFechaEdad($request->fecha_nacimiento, $request->edad)) {//Valida que la fecha de nacimiento coincide con la edad introducida
            return response("La fecha no es válida o no coincide con la edad introducida", 205);
        }

        $perfilUsuario = new PerfilUsuario($request->all());
        $perfilUsuario->save();

        return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));
    }

    public function update(UpdatePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        //Comprobaciones
        if ($request->id_usuario) {

            $cliente = Usuario::find($request->id_usuario);

            if (!$cliente) {
                return response("El cliente indicado no se encuentra registrado", 205);
            }

            if (!Usuario::esCliente($cliente)) {
                return response("El usuario introducido no es un cliente", 401);
            }
        }
        if (is_numeric($request->edad) && $request->edad < 12) {
            return response("La edad debe ser de al menos 12 años", 205);
        }
        if ($request->fecha_nacimiento != null && !Utilities::validarFechaNacimiento($request->fecha_nacimiento)) {//Valida que la fecha de nacimiento coincide con la edad introducida
            return response("La fecha no es válida", 205);
        }

        if ($perfilUsuario) {
            $perfilUsuario->update($request->all());

            //Si se ha modificado la fecha de naciemiento se modificará tambien la edad
            if ($request->fecha_nacimiento != null) {
                $nuevaEdad = Utilities::calcEdad($request->fecha_nacimiento);

                $perfilUsuario->edad = (int) $nuevaEdad;
                $perfilUsuario->save();
            }

            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    public function show(ShowPerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);
        $usuario = $request->user();

        if (!$this->validar($usuario, $perfilUsuario)) {//Si no es gestor ni el propietario ni admin no está autorizado
            return AuthController::UnauthorizedError();
        }
        if ($perfilUsuario) {
            return new PerfilUsuarioResource($perfilUsuario->loadMissing(["usuario"]));

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    public function destroy(DeletePerfilUsuarioRequest $request, $perfilUsuarioId) {
        $perfilUsuario = PerfilUsuario::find($perfilUsuarioId);

        if ($perfilUsuario) {
            $perfilUsuario->delete();

            return response(true);

        } else {
            return response("No existe el perfil indicado", 205);
        }
    }

    private function validar(Usuario $usuario, PerfilUsuario $perfil) {
        if (($usuario->id_usuario != $perfil->id_usuario) && !Usuario::esGestor($usuario) && !Usuario::esAdmin($usuario)) {//Si no es gestor ni admin no está autorizado
            return false;
        }

        return true;
    }
}
