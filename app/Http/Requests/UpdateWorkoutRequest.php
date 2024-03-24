<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateWorkoutRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'exercise_id' => 'exists:exercises,id',
            'repetitions' => 'integer',
            'weight' => 'numeric',
            'break_time' => 'integer',
            'day' => 'in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
            'observations' => 'string',
            'time' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'exercise_id.exists' => 'O ID do exercício fornecido não existe',
            'repetitions.integer' => 'O número de repetições deve ser um número inteiro',
            'weight.numeric' => 'O peso deve ser um número decimal',
            'break_time.integer' => 'O tempo de pausa entre as séries deve ser um número inteiro',
            'day.in' => 'O dia da semana deve ser um dos seguintes: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO',
            'observations.string' => 'As observações devem ser uma string',
            'time.integer' => 'O tempo deve ser um número inteiro',
        ];
    }
}
