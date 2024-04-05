<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\StoreAvaliationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AvaliationRequestValidationTest extends TestCase
{
    public function test_valid_request_passes_validation()
    {
        $request = new StoreAvaliationRequest();
        $validator = validator()->make([
            'student_id' => 1,
            'age' => 25,
            'date' => now(),
            'weight' => 70.5,
            'height' => 170.0,
            'observations_to_student' => 'Observations to student',
            'observations_to_nutritionist' => 'Observations to nutritionist',
            'torax' => 95.0,
            'braco_direito' => 30.0,
            'braco_esquerdo' => 30.0,
            'cintura' => 80.0,
            'antebraco_esquerdo' => 25.0,
            'antebraco_direito' => 25.0,
            'abdomen' => 85.0,
            'coxa_direita' => 45.0,
            'coxa_esquerda' => 45.0,
            'quadril' => 95.0,
            'panturrilha_direita' => 35.0,
            'panturrilha_esquerda' => 35.0,
            'punho' => 15.0,
            'biceps_femoral_direito' => 40.0,
            'biceps_femoral_esquerdo' => 40.0,
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }

    public function test_invalid_request_fails_validation()
    {
        $request = new StoreAvaliationRequest();
        $validator = Validator::make([
            'student_id' => 1,
            'age' => 25,
            'date' => now(),
            'weight' => 70.5,
            'height' => 170.0,
            'observations_to_student' => 'Observations to student',
            'observations_to_nutritionist' => 'Observations to nutritionist',
            'torax' => 95.0,
            'braco_direito' => 30.0,
            'braco_esquerdo' => 30.0,
            'cintura' => 80.0,
            'antebraco_esquerdo' => 25.0,
            'antebraco_direito' => 25.0,
            'abdomen' => 85.0,
            'coxa_direita' => 45.0,
            'coxa_esquerda' => 45.0,
            'quadril' => 'aaaaaa',
            'panturrilha_direita' => 35.0,
            'panturrilha_esquerda' => 35.0,
            'punho' => 15.0,
            'biceps_femoral_direito' => 40.0,
            'biceps_femoral_esquerdo' => 40.0,
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('student_id', $validator->errors()->messages());
    }
}
