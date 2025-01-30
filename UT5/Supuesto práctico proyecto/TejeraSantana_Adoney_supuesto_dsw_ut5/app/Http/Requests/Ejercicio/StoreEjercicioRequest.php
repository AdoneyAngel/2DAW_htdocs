<?php

namespace App\Http\Requests\Ejercicio;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreEjercicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["ejercicios"]);
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
            "descripcion" => ["required"],
            "id_tipo_musculo" => ["required"]
        ];
    }
}
