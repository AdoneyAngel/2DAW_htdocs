<?php

namespace App\Http\Requests\TipoSerie;

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\FormRequest;

class StoreTipoSerieRequest extends FormRequest
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
            "nombre" => ["required"],
            "descripcion" => ["required"]
        ];
    }
}
