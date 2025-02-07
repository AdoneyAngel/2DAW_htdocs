<?php

namespace App\Http\Requests\PerfilUsuario;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class IndexPerfilUsuarioRequest extends FormRequest
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
            //
        ];
    }
}
