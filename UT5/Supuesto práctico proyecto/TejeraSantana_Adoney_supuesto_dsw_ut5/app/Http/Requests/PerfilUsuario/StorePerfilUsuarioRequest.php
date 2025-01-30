<?php

namespace App\Http\Requests\PerfilUsuario;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StorePerfilUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["perfil-clientes"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nombre" => ["required"],
            "apellido1" => ["required"],
            "apellido2" => ["required"],
            "edad" => ["required"],
            "direccion" => ["required"],
            "telefono" => ["required"],
            "foto" => ["required"],
            "fecha_nacimiento" => ["required"],
            "id_usuario" => ["required"],
        ];
    }
}
