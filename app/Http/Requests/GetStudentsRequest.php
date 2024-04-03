<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetStudentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'cpf' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255', 
        ];
    }
}