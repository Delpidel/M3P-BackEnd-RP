<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\DashboardInstructorService;

class DashboardInstructorController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardInstructorService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        try {
            $userId = Auth::id(); // Alterado para obter apenas o id do usuário autenticado
            $data = $this->dashboardService->getDashboardData($userId);

            return response()->json($data, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
