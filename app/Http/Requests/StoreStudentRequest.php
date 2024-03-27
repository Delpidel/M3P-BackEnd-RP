<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStudentRequest extends FormRequest
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
            'photo' => 'file|required|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'string|required|max:255',
            'email' => 'string|required|email|max:255|unique:students',
            'date_birth' => 'date_format:Y-m-d|required',
            'contact' => 'string|required|max:20',
            'cpf' => 'string|required|unique:students|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'cep' => 'string|max:20',
            'street' => 'required|string',
            'state' => 'required|string|max:2',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'number' => 'required|string',
            'complement' => 'string|max: 50'
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'O campo photo é obrigatória',
            'photo.mimes' => 'O campo photo deve ser um arquivo do tipo: jpeg, png, jpg, gif, svg',
            'photo.file' => 'O campo photo deve ser um arquivo',
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres.',
            'email.unique' => 'O email informado já está em uso.',
            'date_birth.date_format' => 'O campo data de nascimento deve estar no formato Ano-Mês-Dia.',
            'date_birth.required' => 'O campo de data de nascimento é obrigatório',
            'contact.required' => 'O campo contato é obrigatório.',
            'contact.max' => 'O campo contato deve ter no máximo 20 caracteres.',
            'cpf.regex' => 'O campo CPF deve estar no formato válido.',
            'cpf.unique' => 'O cpf informado já esta em uso',
            'cep.max' => 'O campo CEP deve ter no máximo 20 caracteres.',
            'cep.required' => 'O campo CEP é obrigatório',
            'city.required' => 'O campo de cidade é obrigatório',
            'city.max' => 'O campo de cidade deve ter no máximo 50 caracteres',
            'neighborhood.required' => 'O campo bairro é obrigatório',
            'neighborhood.max' => 'O campo bairro deve ter no máximo 50 caracteres',
            'number.required' => 'O campo número é obrigatório',
            'number.max' => 'O campo número deve ter no máximo 30 caracteres',
            'street.required' => 'O campo rua deve é obrigatório',
            'street.max' => 'O campo rua deve ter no máximo 30 caracteres',
            'state.required' => 'O campo estado é obrigatório',
            'state.max' => 'O campo estado deve ter no máximo 2 caracteres',
            'complement' => 'O campo de complemento deve ter no máximo 50 caracteres.'
        ];
    }
}
