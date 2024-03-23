<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWorkoutRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'exercise_id' => 'required|exists:exercises,id',
            'repetitions' => 'required|integer',
            'weight' => 'required|numeric',
            'break_time' => 'required|integer',
            'day' => 'required|string|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
            'observations' => 'nullable|string',
            'time' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'repetitions.integer' => 'O número de repetições deve ser um número inteiro',
            'weight.numeric' => 'O peso deve ser um número inteiro ou decimal',
            'break_time.integer' => 'O tempo de pausa entre as séries deve ser um número inteiro',
            'day.in' => 'O dia da semana deve ser um dos seguintes: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO',
            'observations.string' => 'O campo de observações deve conter um texto',
            'time.integer' => 'O tempo deve ser um número inteiro',
        ];
    }
}