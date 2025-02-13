<?php

namespace App\Http\Requests\Suscripcion;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSuscripcionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["suscripciones"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "tipo_suscripcion" => ["sometimes", "required"],
            "id_cliente" => ["sometimes", "required"],
            "precio" => ["sometimes", "required"],
            "dias" => ["sometimes", "required", "min:1"],
            "fecha_inicio" => ["sometimes", "required", "date"],
            "fecha_fin" => ["sometimes", "required", "date"],
        ];
    }
}
