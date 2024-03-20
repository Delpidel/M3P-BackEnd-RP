<?php

namespace App\Http\Services\User;

use App\Http\Repositories\AuthRepository;
use Illuminate\Http\Response;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function response($message, $status, $data)
    {
        return [
            'message' => $message,
            'status' => $status,
            'data' => $data
        ];
    }

    public function login($request)
    {
        $data = $request->only('email', 'password');

        $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        $authenticated = $this->authRepository->attempt($data);

        if (!$authenticated) {
            return response()->json([
                'message' => 'Não autorizado. Credenciais incorretas',
                'status' => Response::HTTP_UNAUTHORIZED
            ], Response::HTTP_UNAUTHORIZED);
        }

        $request->user()->tokens()->delete();
        $profile = $this->authRepository->findProfileById($request->user()->profile_id);
        $permissionsUser =  $this->authRepository->getPermissions($profile->name);

        $token = $request->user()->createToken('@academia', $permissionsUser);

        return $this->response('Autorizado', Response::HTTP_OK, [
            'name' =>  $request->user()->name,
            'profile' => $profile->name,
            'permissions' => $permissionsUser,
            'token' => $token->plainTextToken
        ]);
    }

    public function logout($request)
    {
        $request->user()->tokens()->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
