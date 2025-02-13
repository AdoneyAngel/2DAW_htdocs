<?php

namespace App\Http\Requests\PlanEntrenamiento;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanEntrenamientoRequest extends FormRequest
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
            "id_entrenador" => ["sometimes", "required"],
            "id_cliente" => ["sometimes", "required"],
            "nombre" => ["sometimes", "required"],
            "fecha_inicio" => ["sometimes", "required"],
            "fecha_fin" => ["sometimes", "required"],
        ];
    }
}
