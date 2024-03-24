<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidateExerciseRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Colocar a validação dessa classe
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'string|required|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O nome do exercício é obrigatório',
            'description.string' => 'O nome do exercício deve ser uma string',
            'description.max' => 'O exercício ultrapassa o limite de 255 caracteres'
        ];
    }
}
