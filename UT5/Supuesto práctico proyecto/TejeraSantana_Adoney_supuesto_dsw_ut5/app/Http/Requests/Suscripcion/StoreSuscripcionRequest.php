<?php

namespace App\Http\Requests\Suscripcion;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSuscripcionRequest extends FormRequest
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
            "tipo_suscripcion" => ["required"],
            "id_cliente" => ["required"],
            "precio" => ["required"],
            "dias" => ["required", "min:1"],
            "fecha_inicio" => ["required", "date"],
            "fecha_fin" => ["required", "date"],
        ];
    }
}
