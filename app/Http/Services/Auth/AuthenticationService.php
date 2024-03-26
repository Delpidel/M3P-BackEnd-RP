<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthenticationService
{
    private $authRepository;
    
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function handle(Request $request)
    {
        $data = $request->only('email', 'password');

        $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        return $this->authRepository->attempt($data);
    }
}