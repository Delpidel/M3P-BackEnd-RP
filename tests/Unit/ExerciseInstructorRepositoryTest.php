<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Exercise;
use App\Http\Repositories\ExerciseInstructorRepository;
use App\Http\Services\PaginationInstructorService;
use App\Interfaces\ExerciseInstructorRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ExerciseInstructorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @testdox Recupera exercícios paginados para um usuário específico com exercícios
     */
    public function test_retrieving_paginated_exercises_for_a_specific_user()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $exercises = Exercise::factory()->count(5)->create(['user_id' => $user->id]);

        $expectedResult = new LengthAwarePaginator($exercises, $exercises->count(), 20);

        $paginationServiceMock = $this->createMock(PaginationInstructorService::class);
        $paginationServiceMock->expects($this->once())
            ->method('paginate')
            ->with($this->anything(), $this->equalTo(20), $this->equalTo(['id', 'description']))
            ->willReturn($expectedResult);

        $repository = new ExerciseInstructorRepository($paginationServiceMock);

        $result = $repository->getUserExercises($user->id);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(5, $result->total());
        $this->assertEquals($exercises->pluck('id')->sort()->values(), $result->pluck('id')->sort()->values());
    }

    /**
     * @testdox Recupera exercícios paginados para um usuário específico sem exercícios
     */
    public function test_retrieving_paginated_exercises_for_a_user_with_no_exercises()
    {
        $user = User::factory()->create(['profile_id' => 3]);

        $expectedResult = new LengthAwarePaginator(collect([]), 0, 10);

        $paginationServiceMock = $this->createMock(PaginationInstructorService::class);
        $paginationServiceMock->expects($this->once())
            ->method('paginate')
            ->willReturn($expectedResult);

        $repository = new ExerciseInstructorRepository($paginationServiceMock);
        $result = $repository->getUserExercises($user->id);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(0, $result->total());
    }

    /**
     * @testdox Verifica o comportamento correto da paginação para os exercícios de um usuário
     */
    public function test_correct_pagination_behavior_for_user_exercises()
    {
        $user = User::factory()->create(['profile_id' => 3]);

        Exercise::factory()->count(20)->create(['user_id' => $user->id]);

        $paginationServiceMock = $this->createMock(PaginationInstructorService::class);

        $paginationServiceMock->method('paginate')->willReturnCallback(function ($query, $perPage) {
            return new LengthAwarePaginator($query->take($perPage)->get(), 20, $perPage);
        });

        $repository = new ExerciseInstructorRepository($paginationServiceMock);
        $result = $repository->getUserExercises($user->id);

        $this->assertCount(20, $result->items());
        $this->assertEquals(20, $result->total());
    }

    /**
     * @testdox Assegura que o ServiceProvider vincula corretamente o repositório e o serviço de paginação
     */
    public function test_service_provider_bindings()
    {
        $repository = app(ExerciseInstructorRepositoryInterface::class);
        $this->assertInstanceOf(ExerciseInstructorRepository::class, $repository);

        $paginationService = app(PaginationInstructorService::class);
        $this->assertInstanceOf(PaginationInstructorService::class, $paginationService);
    }
}
