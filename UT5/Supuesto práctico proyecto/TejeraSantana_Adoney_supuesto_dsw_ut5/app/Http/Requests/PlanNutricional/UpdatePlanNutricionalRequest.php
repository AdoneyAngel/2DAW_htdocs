<?php

namespace App\Http\Requests\PlanNutricional;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanNutricionalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["planes-nutricionales"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "id_nutricionista" => ["sometimes", "required"],
            "id_cliente" => ["sometimes", "required"],
            "nombre" => ["sometimes", "required"],
            "recomendaciones_dieta" => ["sometimes", "required"],
            "porcentaje_carbohidratos" => ["sometimes", "required"],
            "porcentaje_proteinas" => ["sometimes", "required"],
            "porcentaje_grasas" => ["sometimes", "required"],
            "porcentaje_fibra" => ["sometimes", "required"],
            "fecha_inicio" => ["sometimes", "required"],
            "fecha_fin" => ["sometimes", "required"],
        ];
    }
}
