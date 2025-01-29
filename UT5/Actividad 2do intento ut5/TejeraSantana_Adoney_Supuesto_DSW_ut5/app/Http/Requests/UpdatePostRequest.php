<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null && $this->user()->tokenCan("create");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "titulo" => ["sometimes", "required"],
            "cuerpo" => ["sometimes", "required"],
            "imagen" => ["sometimes", "required"],
            "usuario_id" => ["sometimes", "required"],
            "categoria_id" => ["sometimes", "required"],
        ];
    }
}
