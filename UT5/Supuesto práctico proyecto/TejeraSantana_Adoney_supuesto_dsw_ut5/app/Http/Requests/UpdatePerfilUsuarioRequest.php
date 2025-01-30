<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        if (!$usuario || $usuario == null) {
            return false;
        }

        if ($usuario->tokenCan("admin") || $usuario->tokenCan("perfil-clientes")) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nombre" => ["sometimes", "required"],
            "apellido1" => ["sometimes", "required"],
            "apellido2" => ["sometimes", "required"],
            "edad" => ["sometimes", "required"],
            "direccion" => ["sometimes", "required"],
            "telefono" => ["sometimes", "required"],
            "foto" => ["sometimes", "required"],
            "fecha_nacimiento" => ["sometimes", "required"],
            "id_usuario" => ["sometimes", "required"],
        ];
    }
}
