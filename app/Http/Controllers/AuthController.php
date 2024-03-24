<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Services\Auth\LoginService;
use App\Http\Services\Auth\LogoutService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $loginService;
    private $logoutService;

    public function __construct(LoginService $loginService, LogoutService $logoutService)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    public function store(Request $request)
    {
        return $this->loginService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->logoutService->logout($request);
    }
}