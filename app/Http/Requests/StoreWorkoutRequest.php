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
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'O campo de identificação do aluno é obrigatório.',
            'student_id.exists' => 'O aluno selecionado não existe.',
            'exercise_id.required' => 'O campo de identificação do exercício é obrigatório.',
            'exercise_id.exists' => 'O exercício selecionado não existe.',
            'repetitions.required' => 'O número de repetições é obrigatório.',
            'repetitions.integer' => 'O número de repetições deve ser um número inteiro.',
            'weight.required' => 'O peso é obrigatório.',
            'weight.numeric' => 'O peso deve ser um número inteiro ou decimal.',
            'break_time.required' => 'O tempo de pausa entre as séries é obrigatório.',
            'break_time.integer' => 'O tempo de pausa entre as séries deve ser um número inteiro.',
            'day.required' => 'O dia da semana é obrigatório.',
            'day.string' => 'O dia da semana deve ser uma string.',
            'day.in' => 'O dia da semana deve ser um dos seguintes: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO.',
            'observations.string' => 'O campo de observações deve conter um texto.',
        ];
    }
}

