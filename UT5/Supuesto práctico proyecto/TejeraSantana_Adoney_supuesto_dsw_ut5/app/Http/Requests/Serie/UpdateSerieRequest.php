<?php

namespace App\Http\Requests\Serie;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSerieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = $this->user();

        return AuthController::authRequest($usuario, ["series"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "repeticiones_min" => ["sometimes", "required"],
            "repeticiones_max" => ["sometimes", "required"],
            "peso" => ["sometimes", "required"],
            "duracion" => ["sometimes", "required"],
            "descanso" => ["sometimes", "required"],
            "id_ejercicio" => ["sometimes", "required"],
            "id_tabla" => ["sometimes", "required"],
            "id_tipo_serie" => ["sometimes", "required"],
        ];
    }
}
