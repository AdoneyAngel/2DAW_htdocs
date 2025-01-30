<?php

namespace App\Http\Requests\EstadisticaCliente;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreEstadisticaClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["estadisticas-clientes"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "peso" => ["required"],
            "altura" => ["required"],
            "grasa_corporal" => ["required"],
            "cintura" => ["required"],
            "pecho" => ["required"],
            "pierna" => ["required"],
            "biceps" => ["required"],
            "triceps" => ["required"],
            "id_cliente" => ["required"],
        ];
    }
}
