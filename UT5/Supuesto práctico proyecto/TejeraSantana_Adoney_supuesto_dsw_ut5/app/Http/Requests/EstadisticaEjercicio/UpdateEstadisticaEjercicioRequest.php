<?php

namespace App\Http\Requests\EstadisticaEjercicio;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadisticaEjercicioRequest extends FormRequest
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
            "id_ejercicio" => ["sometimes", "required"],
            "num_sesiones" => ["sometimes", "required"],
            "tiempo_total" => ["sometimes", "required"],
            "duracion_media" => ["sometimes", "required"],
            "sets_completados" => ["sometimes", "required"],
            "volumen_total" => ["sometimes", "required"],
            "repeticiones_totales" => ["sometimes", "required"],
            "fecha_entrenamiento" => ["sometimes", "required"],
        ];
    }
}
