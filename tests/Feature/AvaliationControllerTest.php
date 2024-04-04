<?php

namespace Tests\Feature;

use App\Models\Avaliation;
use App\Models\Student;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function xdebug_break;


class AvaliationControllerTest extends TestCase
{
    use RefreshDatabase;

    // Remove the line below

    public function test_store_method_stores_avaliation_and_files()
    {

        $nutricionista = User::factory()->create(['profile_id' => 4]);


        $this->actingAs($nutricionista);

        $avaliationData = Avaliation::factory()->raw();


        $data = [
            'student_id' => Student::factory()->create()->id,
            'age' => $avaliationData['age'],
            'date' => $avaliationData['date'],
            'weight' => $avaliationData['weight'],
            'height' => $avaliationData['height'],
            'observations_to_student' => $avaliationData['observations_to_student'],
            'observations_to_nutritionist' => $avaliationData['observations_to_nutritionist'],
            'back' => $avaliationData['back'],
            'front' => $avaliationData['front'],
            'left' => $avaliationData['left'],
            'right' => $avaliationData['right'],
            'torax' => $avaliationData['torax'],
            'braco_direito' => $avaliationData['braco_direito'],
            'braco_esquerdo' => $avaliationData['braco_esquerdo'],
            'cintura' => $avaliationData['cintura'],
            'antebraco_direito' => $avaliationData['antebraco_direito'],
            'antebraco_esquerdo' => $avaliationData['antebraco_esquerdo'],
            'abdomen' => $avaliationData['abdomen'],
            'coxa_direita' => $avaliationData['coxa_direita'],
            'coxa_esquerda' => $avaliationData['coxa_esquerda'],
            'quadril' => $avaliationData['quadril'],
            'panturrilha_direita' => $avaliationData['panturrilha_direita'],
            'panturrilha_esquerda' => $avaliationData['panturrilha_esquerda'],
            'punho' => $avaliationData['punho'],
            'biceps_femoral_direito' => $avaliationData['biceps_femoral_direito'],
            'biceps_femoral_esquerdo' => $avaliationData['biceps_femoral_esquerdo'],
        ];

        // Execução
        $response = $this->post('/avaliations', $data);
        xdebug_break();

        // Verificação
         $response->assertStatus(201);

    }
}
