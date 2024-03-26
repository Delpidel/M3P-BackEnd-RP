<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Services\DashboardInstructorService;
use Mockery;
use App\Interfaces\DashboardInstructorRepositoryInterface;

class DashboardInstructorServiceTest extends TestCase
{

    /**
     * @testdox Verifica se o serviço retorna corretamente os dados do dashboard para um usuário
     */
    public function test_get_dashboard_data()
    {
        $repositoryMock = Mockery::mock(DashboardInstructorRepositoryInterface::class);
        $repositoryMock->shouldReceive('getAmountOfStudents')->once()->andReturn(5);
        $repositoryMock->shouldReceive('getAmountOfExercises')->once()->andReturn(10);

        $service = new DashboardInstructorService($repositoryMock);
        $data = $service->getDashboardData(1);

        $this->assertEquals(['registered_students' => 5, 'registered_exercises' => 10], $data);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
