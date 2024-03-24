<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\AuthRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LogoutService
{
    use HttpResponses;
    private $authRepository;
    private $tokenRevocationService;

    public function __construct(
        AuthRepository $authRepository,
        TokenRevocationService $tokenRevocationService)
    {
        $this->authRepository = $authRepository;
        $this->tokenRevocationService = $tokenRevocationService;
    }

    public function logout($request)
    {
        $this->tokenRevocationService->revokeTokens($request);
        return response('', Response::HTTP_NO_CONTENT, []);
    }
}
