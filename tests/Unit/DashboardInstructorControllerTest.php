<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Services\DashboardInstructorService;
use Illuminate\Support\Facades\Auth;
use Mockery;

class DashboardInstructorControllerTest extends TestCase
{
    /**
     * @testdox Verifica se o index retorna os dados corretamente para o usuário autenticado
     */
    public function test_index_returns_data_correctly()
    {
        $serviceMock = Mockery::mock(DashboardInstructorService::class);
        $serviceMock->shouldReceive('getDashboardData')
            ->once()
            ->with(Mockery::on(function ($userId) {
                return is_numeric($userId);
            }))
            ->andReturn([
                'registered_students' => 5,
                'registered_exercises' => 10,
            ]);

        Auth::shouldReceive('id')->once()->andReturn(1);

        $controller = new DashboardInstructorController($serviceMock);

        $request = new Request();
        $response = $controller->index($request);

        $data = $response->getData(true);

        $this->assertEquals(200, $response->status());
        $this->assertEquals(5, $data['registered_students']);
        $this->assertEquals(10, $data['registered_exercises']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @testdox Verifica se o index lida corretamente com exceções do serviço
     */
    public function test_index_handles_service_exception()
    {
        $serviceMock = Mockery::mock(DashboardInstructorService::class);
        $serviceMock->shouldReceive('getDashboardData')
            ->once()
            ->andThrow(new \Exception("Error Processing Request"));

        Auth::shouldReceive('id')->once()->andReturn(1);

        $controller = new DashboardInstructorController($serviceMock);

        $request = new Request();
        $response = $controller->index($request);

        $this->assertEquals(500, $response->status());
        $this->assertEquals("Error Processing Request", $response->getData(true)['error']);
    }
}
