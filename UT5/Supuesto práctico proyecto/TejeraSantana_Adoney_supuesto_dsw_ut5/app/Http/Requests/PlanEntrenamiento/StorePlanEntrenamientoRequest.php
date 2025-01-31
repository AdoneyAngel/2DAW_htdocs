<?php

namespace App\Http\Requests\PlanEntrenamiento;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StorePlanEntrenamientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["planes-entrenamientos"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "id_entrenador" => ["required"],
            "id_cliente" => ["required"],
            "nombre" => ["required"],
            "fecha_inicio" => ["required"],
            "fecha_fin" => ["required"],
            "tablas_entrenamiento" => ["sometimes", "required", "array"]
        ];
    }
}
