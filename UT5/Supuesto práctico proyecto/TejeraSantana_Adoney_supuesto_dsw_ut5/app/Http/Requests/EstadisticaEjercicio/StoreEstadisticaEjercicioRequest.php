<?php

namespace App\Http\Requests\EstadisticaEjercicio;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreEstadisticaEjercicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["estadisticas-ejercicios"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "id_ejercicio" => ["required"],
            "num_sesiones" => ["required"],
            "tiempo_total" => ["required"],
            "duracion_media" => ["required"],
            "sets_completados" => ["required"],
            "volumen_total" => ["required"],
            "repeticiones_totales" => ["required"],
            "fecha_entrenamiento" => ["required"],
        ];
    }
}
