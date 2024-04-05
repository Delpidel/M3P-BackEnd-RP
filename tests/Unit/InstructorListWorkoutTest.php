<?php

namespace Tests\Feature;

use App\Http\Controllers\InstructorWorkoutController;
use App\Http\Services\Workout\InstructorListWorkoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use App\Models\Workout;
use Mockery;
use Tests\TestCase;

class InstructorListWorkoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_instructor_can_list_student_workout_status_200(): void
    {
        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);
        $student = Student::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/api/students/$student->id/workouts");

        $response->assertStatus(200);
    }


    public function test_instructor_list_workouts_api_response()
    {
        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        $student->update(['student_name' => $student->name]);

        $exercise = Exercise::factory()->create();

        $workout = Workout::factory()->create([
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 10,
            'weight' => 50.5,
            'break_time' => 60,
            'observations' => 'supino',
            'time' => 10,
            'user_id' => $user->id,
            'day' => 'SEGUNDA',
        ]);

        $response = $this->actingAs($user)->get("/api/students/$student->id/workouts");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'student_id',
            'student_name',
            'workouts' => [
                'SEGUNDA',
                'TERCA',
                'QUARTA',
                'QUINTA',
                'SEXTA',
                'SABADO',
                'DOMINGO'
            ]
        ]);

        $response->assertJson([
            'student_id' => $student->id,
            'student_name' => $student->name,
            'workouts' => [
                'SEGUNDA' => [
                    [
                        'id' => $workout->id,
                        'student_id' => $student->id,
                        'exercise_id' => $exercise->id,
                        'repetitions' => 10,
                        'weight' => 50.5,
                        'break_time' => 60,
                        'observations' => 'supino',
                        'time' => 10,
                        'user_id' => $user->id,
                        'day' => 'SEGUNDA',

                    ]
                ],
                'TERCA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SABADO' => [],
                'DOMINGO' => [],
            ]
        ]);
    }

    public function test_user_with_non_instructor_profile_status_403()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create(['profile_id' => 4]);
        $token = $user->createToken('12345678', [''])->plainTextToken;

        $student = Student::factory()->create(['user_id' => $user->id]);

        $this->expectException(\Laravel\Sanctum\Exceptions\MissingAbilityException::class);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get("/api/students/$student->id/workouts");

        $response->assertStatus(403);
    }

    public function test_listWorkouts_method_handles_exception_properly()
    {
        $listWorkoutService = Mockery::mock(InstructorListWorkoutService::class);

        $listWorkoutService->shouldReceive('listWorkouts')
            ->andThrow(new \Exception('Erro de exemplo'));

        $controller = new InstructorWorkoutController();


        $response = $controller->listWorkouts(1, $listWorkoutService);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals('Erro de exemplo', $response->getData()->message);
    }
}
