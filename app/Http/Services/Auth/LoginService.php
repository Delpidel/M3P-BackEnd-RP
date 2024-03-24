<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\AuthRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use App\Http\Requests\AuthRequest;

class LoginService
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

    public function login($request)
    {
        $authenticated = $this->authenticationService->authenticate($request);

        if (!$authenticated) {
            return $this->error("Não autorizado. Credenciais incorretas", Response::HTTP_UNAUTHORIZED);
        }

        $this->tokenRevocationService->revokeTokens($request);
        $profile = $this->getProfileService->getProfile($request);

        // Gestão do token
        $permissionsUser = $this->getPermissionsService->getPermissionsForProfile($profile->name);
        $token = $this->tokenManagementService->manageToken($request, $profile);

        return $this->response('Autorizado', Response::HTTP_OK, [
            'name' =>  $request->user()->name,
            'profile' => $profile->name,
            'permissions' => $permissionsUser,
            'token' => $token
        ]);
    }
}
