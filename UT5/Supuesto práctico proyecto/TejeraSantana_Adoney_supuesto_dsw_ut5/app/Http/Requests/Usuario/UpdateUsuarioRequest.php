<?php

namespace App\Http\Requests\Usuario;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["usuarios"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ["sometimes", "required"],
            "token" => ["sometimes", "required"],
            "clave" => ["sometimes", "required"],
            "id_tipo_usuario" => ["sometimes", "required"],
            "fecha_registro" => ["sometimes", "required"],
        ];
    }
}
