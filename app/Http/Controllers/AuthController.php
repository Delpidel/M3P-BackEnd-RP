<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\AuthRequest;
use App\Http\Services\Auth\AuthenticationService;
use App\Http\Services\Auth\GetPermissionsService;
use App\Http\Services\Auth\GetProfileService;
use App\Http\Services\Auth\TokenManagementService;
use App\Http\Services\Auth\TokenRevocationService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use HttpResponses;
    private $authRepository;
    private $authenticationService;
    private $tokenRevocationService;
    private $getProfileService;
    private $tokenManagementService;
    private $getPermissionsService;

    public function __construct(
        AuthRepository $authRepository,
        AuthenticationService $authenticationService,
        TokenRevocationService $tokenRevocationService,
        GetProfileService $getProfileService,
        TokenManagementService $tokenManagementService,
        GetPermissionsService $getPermissionsService
    ) {
        $this->authRepository = $authRepository;
        $this->authenticationService = $authenticationService;
        $this->tokenRevocationService = $tokenRevocationService;
        $this->getProfileService = $getProfileService;
        $this->tokenManagementService = $tokenManagementService;
        $this->getPermissionsService = $getPermissionsService;
    }

    public function store(Request $request)
    {
        $authenticated = $this->authenticationService->handle($request);

        if (!$authenticated) {
            return $this->error("Não autorizado. Credenciais incorretas", Response::HTTP_UNAUTHORIZED);
        }

        $this->tokenRevocationService->handle($request);
        $profile = $this->getProfileService->handle($request);

        $permissionsUser = $this->getPermissionsService->handle($profile->name);
        $token = $this->tokenManagementService->handle($request, $profile);

        return $this->response('Autorizado', Response::HTTP_OK, [
            'name' =>  $request->user()->name,
            'profile' => $profile->name,
            'permissions' => $permissionsUser,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $this->tokenRevocationService->handle($request);
        return response('', Response::HTTP_NO_CONTENT, []);
    }
}