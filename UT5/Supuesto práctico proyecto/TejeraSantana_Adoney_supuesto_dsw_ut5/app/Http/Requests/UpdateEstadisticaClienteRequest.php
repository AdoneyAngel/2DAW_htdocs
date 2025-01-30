<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstadisticaClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        if (!$usuario || $usuario == null) {
            return false;
        }

        if ($usuario->tokenCan("admin") || $usuario->tokenCan("estadisticas-clientes")) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "peso" => ["sometimes", "required"],
            "altura" => ["sometimes", "required"],
            "grasa_corporal" => ["sometimes", "required"],
            "cintura" => ["sometimes", "required"],
            "pecho" => ["sometimes", "required"],
            "pierna" => ["sometimes", "required"],
            "biceps" => ["sometimes", "required"],
            "triceps" => ["sometimes", "required"],
            "id_cliente" => ["sometimes", "required"],
        ];
    }
}
