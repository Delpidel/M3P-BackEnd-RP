<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Repositories\DashboardInstructorRepository;
use App\Models\User;
use Database\Factories\DashboardExerciseFactory;
use Database\Factories\DashboardStudentFactory;

class DashboardInstructorRepositoryTest extends TestCase
{
    /**
     * @testdox Verifica a contagem correta de estudantes para um usuário
     */
    public function test_get_amount_of_students()
    {
        $user = User::factory()->create();

        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfStudents($user->id);

        $this->assertEquals($user->students()->count(), $count);
    }

    /**
     * @testdox Verifica a contagem correta de exercícios para um usuário
     */
    public function test_get_amount_of_exercises()
    {
        $user = User::factory()->create();

        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfExercises($user->id);

        $this->assertEquals($user->exercises()->count(), $count);
    }

    /**
     * @testdox Verifica que a contagem de estudantes é zero quando não há estudantes
     */
    public function test_get_amount_of_students_with_no_students()
    {
        $user = User::factory()->create();
        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfStudents($user->id);
        $this->assertEquals(0, $count);
    }

    /**
     * @testdox Verifica que a contagem de exercícios é zero quando não há exercícios
     */
    public function test_get_amount_of_exercises_with_no_exercises()
    {
        $user = User::factory()->create();
        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfExercises($user->id);
        $this->assertEquals(0, $count);
    }

    /**
     * @testdox Verifica se estudantes de outros usuários não são incluídos na contagem
     */
    public function test_it_excludes_students_assigned_to_other_users()
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        DashboardStudentFactory::new()->create(['user_id' => $otherUser->id]);

        DashboardStudentFactory::new()->count(3)->create(['user_id' => $user->id]);

        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfStudents($user->id);

        $this->assertEquals(3, $count);
    }

    /**
     * @testdox Verifica se exercícios de outros usuários não são incluídos na contagem
     */
    public function test_it_excludes_exercises_created_by_other_users()
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        DashboardExerciseFactory::new()->create(['user_id' => $otherUser->id]);

        DashboardExerciseFactory::new()->count(5)->create(['user_id' => $user->id]);

        $repository = new DashboardInstructorRepository();
        $count = $repository->getAmountOfExercises($user->id);

        $this->assertEquals(5, $count);
    }
}
