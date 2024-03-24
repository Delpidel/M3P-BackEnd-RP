<?php

namespace App\Http\Services\Auth;

use Illuminate\Http\Request;

class TokenManagementService
{
    private $getPermissionsService;

    public function __construct(GetPermissionsService $getPermissionsService)
    {
        $this->getPermissionsService = $getPermissionsService;
    }

    public function handle(Request $request, $profile)
    {
        $permissionsUser = $this->getPermissionsService->handle($profile->name);
        $token = $request->user()->createToken('@academia', $permissionsUser);

        return $token->plainTextToken;
    }
}