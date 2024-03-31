<?php

namespace App\Http\Controllers;

use App\Http\Services\Dashboard\DashboardService;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $dashboardData = $this->dashboardService->getDashboardData();
        return $this->response('Dashboard carregado com sucesso.', Response::HTTP_OK, $dashboardData);
    }
}