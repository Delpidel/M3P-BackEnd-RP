<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAvaliationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            
            'student_id' => 'required|exists:students,id',
            'age' => 'required|integer|min:0',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'observations_to_student' => 'nullable|string',
            'observations_to_nutritionist' => 'nullable|string',
            'torax' => 'required|numeric',
            'braco_direito' => 'required|numeric',
            'braco_esquerdo' => 'required|numeric',
            'cintura' => 'required|numeric',
            'antebraco_esquerdo' => 'required|numeric',
            'antebraco_direito' => 'required|numeric',
            'abdomen' => 'required|numeric',
            'coxa_direita' => 'required|numeric',
            'coxa_esquerda' => 'required|numeric',
            'quadril' => 'required|numeric',
            'panturrilha_direita' => 'required|numeric',
            'panturrilha_esquerda' => 'required|numeric',
            'punho' => 'required|numeric',
            'biceps_femoral_direito' => 'required|numeric',
            'biceps_femoral_esquerdo' => 'required|numeric',
            
        ];
    }

    public function messages(): array
    {
        return [
        'student_id.required' => 'O ID do estudante é obrigatório.',
        'age.required' => 'A idade é obrigatória.',
        'date.required' => 'A data é obrigatória.',
        'weight.required' => 'O peso é obrigatório.',
        'height.required' => 'A altura é obrigatória.',
        'image' => 'O ID do arquivo é obrigatório.',
        'torax.required' => 'A medida do tórax é obrigatória.',
        'braco_direito.required' => 'A medida do braço direito é obrigatória.',
        'braco_esquerdo.required' => 'A medida do braço esquerdo é obrigatória.',
        'cintura.required' => 'A medida da cintura é obrigatória.',
        'antebraco_esquerdo.required' => 'A medida do antebraço esquerdo é obrigatória.',
        'antebraco_direito.required' => 'A medida do antebraço direito é obrigatória.',
        'abdomen.required' => 'A medida do abdomen é obrigatória.',
        'coxa_direita.required' => 'A medida da coxa direita é obrigatória.',
        'coxa_esquerda.required' => 'A medida da coxa esquerda é obrigatória.',
        'quadril.required' => 'A medida do quadril é obrigatória.',
        'panturrilha_direita.required' => 'A medida da panturrilha direita é obrigatória.',
        'panturilha_esquerda.required' => 'A medida da panturrilha esquerda é obrigatória.',
        'punho.required' => 'A medida do punho é obrigatória.',
        'biceps_femoral_direito.required' => 'A medida do bíceps femoral direito é obrigatório.',
        'biceps_femoral_esquerdo.required' => 'A do bíceps femoral esquerdo é obrigatório.',
        ];
    }
}
