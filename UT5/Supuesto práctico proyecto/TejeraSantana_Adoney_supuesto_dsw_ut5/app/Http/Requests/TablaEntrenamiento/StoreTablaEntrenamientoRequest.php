<?php

namespace App\Http\Requests\TablaEntrenamiento;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreTablaEntrenamientoRequest extends FormRequest
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
            "semana" => ["required"],
            "nombre" => ["required"],
            "num_series" => ["required"],
            "num_ejercicios" => ["required"],
            "num_dias" => ["required"],
        ];
    }
}
