<?php

namespace Tests\Unit;

use App\Http\Repositories\CreateWorkoutRepository;
use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Services\Workout\CreateWorkoutService;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateWorkoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_catch_exception(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create();

        $this->actingAs($user);

        $workout = $this->post('/api/workouts', [

            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 10,
            // O erro ao montar o workout está nesta linha abaixo
            'weight' => 's',
            'break_time' => 10,
            'day' => 'SEGUNDA',
            'observations' => 'Observações',
            'time' => 10,
        ]);

        $responseData = $workout->json();
        $workout->assertStatus(400);
        $this->assertEquals('O peso deve ser um número inteiro ou decimal.', $responseData['message']);

        if (array_key_exists('status', $responseData)) {
            $this->assertEquals(400, $responseData['status']);
        } else {
            $this->fail('A chave "status" não está definida no array de resposta');
        }
    }

    public function test_create_workout(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 10,
            'weight' => 10,
            'break_time' => 10,
            'day' => 'SEGUNDA',
            'observations' => 'Observações',
            'time' => 60,
        ];

        // Valida os dados da requisição usando regras e mensagens do StoreWorkoutRequest
        $request = new StoreWorkoutRequest();
        $validator = $this->app['validator']->make($data, $request->rules(), $request->messages());

        $this->assertFalse($validator->fails(), 'Os dados da requisição não passaram na validação.');

        // Se os dados passarem na validação, continuar com a criação do treino
        $response = $this->actingAs($user)->post('/api/workouts', $data);

        $response->assertStatus(201);
        $response->assertJson([
            // Verifica se os dados retornados correspondem aos dados enviados
            'student_id' => $data['student_id'],
            'exercise_id' => $data['exercise_id'],
            'repetitions' => $data['repetitions'],
            'weight' => $data['weight'],
            'break_time' => $data['break_time'],
            'day' => $data['day'],
            'observations' => $data['observations'],
            'time' => $data['time'],
        ]);

        // Verifica se o treino foi realmente criado no banco de dados
        $this->assertDatabaseHas('workouts', $data);
    }

    public function test_exercise_already_exists()
    {
        // exercício já está cadastrado para o aluno naquele mesmo dia
        $data = [
            'student_id' => 1,
            'exercise_id' => 1,
            'day' => 'SEGUNDA',
        ];

        // Mock para retornar true indicando que o exercício já está cadastrado para o dia
        $createWorkoutRepositoryMock = $this->createMock(CreateWorkoutRepository::class);
        $createWorkoutRepositoryMock->method('exerciseExists')->willReturn(true);

        // Criar uma instância do serviço passando o repositório mockado
        $createWorkoutService = new CreateWorkoutService($createWorkoutRepositoryMock);

        // Verificar se o método handle lança uma exceção quando o exercício já está cadastrado para o dia
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Exercício já cadastrado para esse dia');

        // Chamar o método handle com os dados preparados
        $createWorkoutService->handle($data);
    }

    //Testes abaixo verificam valores individuais
    public function test_invalid_student_id(): void
    {
        $request = new StoreWorkoutRequest();

        // Informa um ID inexistente do student
        $data = [
            'student_id' => 9999999999,
            'exercise_id' => 1,
            'repetitions' => 10,
            'weight' => 10.5,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O aluno selecionado não existe.'], $validator->errors()->get('student_id'));
    }

    public function test_repetitions_required(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            // 'repetitions' =>  Este campo não é enviado, por isso deve falhar a validação
            'weight' => 10.5,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O número de repetições é obrigatório.'], $validator->errors()->get('repetitions'));
    }

    public function test_repetitions_invalid(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  'teste',  // campo enviando string
            'weight' => 10.5,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O número de repetições deve ser um número inteiro.'], $validator->errors()->get('repetitions'));
    }

    public function test_weight_required(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  12,
            // 'weight' => 10.5,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O peso é obrigatório.'], $validator->errors()->get('weight'));
    }

    public function test_weight_invalid(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  12,
            'weight' => 'teste', //valor invalido para weight
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O peso deve ser um número inteiro ou decimal.'], $validator->errors()->get('weight'));
    }

    public function test_break_time_required(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  12,
            'weight' => 12.5,
            // 'break_time' => 5, //Este campo está vazio, por isso deve falhar a validação
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O tempo de pausa entre as séries é obrigatório.'], $validator->errors()->get('break_time'));
    }

    public function test_break_time_invalid(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  12,
            'weight' => 12.5,
            'break_time' => 'Teste',
            'day' => 'SEGUNDA',
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O tempo de pausa entre as séries deve ser um número inteiro.'], $validator->errors()->get('break_time'));
    }

    public function test_day_required(): void
    {

        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' =>  12,
            'weight' => 12.5,
            'break_time' => 1,
            // 'day' => 'SEGUNDA',  //Este campo está vazio, por isso deve falhar a validação
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O dia da semana é obrigatório.'], $validator->errors()->get('day'));
    }

    public function test_day_invalid(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 12,
            'weight' => 12.5,
            'break_time' => 1,
            'day' => 1, // valor inválido para day
            'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());
        Log::info($validator->errors()->all());

        $this->assertTrue($validator->fails());

        $this->assertEquals(
            ['O dia da semana deve ser uma string.', 'O dia da semana deve ser um dos seguintes: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO.'],
            $validator->errors()->get('day')
        );
    }

    public function test_time_required(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 12,
            'weight' => 12.5,
            'break_time' => 1,
            'day' => 'SEGUNDA',
            // 'time' => 60,
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());
        Log::info($validator->errors()->all());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O tempo é obrigatório.'], $validator->errors()->get('time'));
    }

    public function test_time_invalid(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);

        $request = new StoreWorkoutRequest();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 12,
            'weight' => 12.5,
            'break_time' => 1,
            'day' => 'SEGUNDA',
            'time' => 'teste',
        ];

        $validator = Validator::make($data, $request->rules(), $request->messages());
        Log::info($validator->errors()->all());

        $this->assertTrue($validator->fails());

        $this->assertEquals(['O tempo deve ser um número inteiro.'], $validator->errors()->get('time'));
    }
}
