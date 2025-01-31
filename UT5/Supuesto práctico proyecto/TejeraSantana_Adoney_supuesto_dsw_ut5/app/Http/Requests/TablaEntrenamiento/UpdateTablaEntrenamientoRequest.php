<?php

namespace App\Http\Requests\TablaEntrenamiento;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTablaEntrenamientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["tablas-entrenamientos"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "semana" => ["sometimes", "required"],
            "nombre" => ["sometimes", "required"],
            "num_series" => ["sometimes", "required"],
            "num_ejercicios" => ["sometimes", "required"],
            "num_dias" => ["sometimes", "required"],
            "planes_entrenamiento" => ["sometimes", "required", "array"]
        ];
    }
}
