<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\AuthRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use App\Http\Requests\AuthRequest;


class AuthService
{
    use HttpResponses;
    private $authRepository;

    private $permissions = [
        'ADMIN' => [
            'create-users',
            'get-users',
            'delete-users',
            'update-users',
            'admin-dashboard',
        ],
        'RECEPCIONISTA' => [
            'create-students',
            'get-students',
            'delete-students',
            'update-students',
            'create-documents-students',
            'get-documents-students',
            'get-avaliations'
        ],
        'INSTRUTOR' => [
            'instrutor-dashboard',
            'create-exercises',
            'get-exercises',
            'delete-exercises',
            'get-students',
            'create-workouts',
            'get-workouts',
            'delete-workouts',
            'update-workouts'
        ],
        'NUTRICIONISTA' => [
            'create-avaliations',
            'get-actives-students',
            'get-avaliations',
            'create-meal-plans',
            'get-meal-plans'
        ],
        'ALUNO' => [
            'get-workout',
            'get-meal-plans'
        ]
    ];

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
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
            return $this->error("Não autorizado. Credenciais incorretas", 
            Response::HTTP_UNAUTHORIZED);
        }

        $request->user()->tokens()->delete();
        $profile = $this->authRepository->findProfileById($request->user()->profile_id);
        $permissionsUser = $this->permissions[$profile->name] ?? [];

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
        return response('', Response::HTTP_NO_CONTENT, []);
    }

}
