<?php

namespace App\Http\Controllers;

use App\Http\Services\Dashboard\DashboardService;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $dashboardData = $this->dashboardService->getDashboardData();
        return response()->json($dashboardData, Response::HTTP_OK);
    }
}
