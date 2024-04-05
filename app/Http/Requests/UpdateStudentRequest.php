<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:students',
            'date_birth' => 'string|date_format:Y-m-d',
            'cpf' => 'string|max:14||regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/|unique:students',
            'contact' => 'string',
            'cep' => 'string',
            'street' => 'string',
            'state' => 'string',
            'neighborhood' => 'string',
            'city' => 'string',
            'number' => 'string',
		    'contact' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.email' => 'O campo email deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres.',
            'email.unique' => 'O email informado já está em uso.',
            'date_birth.date_format' => 'O campo data de nascimento deve estar no formato Ano-Mês-Dia.',
            'cpf.regex' => 'O campo CPF deve estar no formato válido.',
        ];
    }
}
