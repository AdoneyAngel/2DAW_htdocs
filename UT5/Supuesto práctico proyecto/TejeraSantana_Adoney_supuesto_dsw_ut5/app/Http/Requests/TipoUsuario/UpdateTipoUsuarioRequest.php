<?php

namespace App\Http\Requests\TipoUsuario;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "tipo_usuario" => ["sometimes", "required"],
            "descripcion" => ["sometimes", "required"]
        ];
    }
}
