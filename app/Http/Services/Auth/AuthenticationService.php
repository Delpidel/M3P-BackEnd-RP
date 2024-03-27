<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthenticationService
{
    private $authRepository;
    
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function handle($data)
    {
        return $this->authRepository->attempt($data);
    }
}