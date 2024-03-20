<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Traits\HttpResponses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use HttpResponses;

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

    public function store(Request $request)
    {
            $data = $request->only('email', 'password');

            $request->validate([
                'email' => 'string|required',
                'password' => 'string|required'
            ]);

            $authenticated = Auth::attempt($data);

            if (!$authenticated) {
                return $this->error('Não autorizado. Credenciais incorretas', Response::HTTP_UNAUTHORIZED);
            }

            $request->user()->tokens()->delete();
            $profile = Profile::find($request->user()->profile_id);
            $permissionsUser =  $this->permissions[$profile->name];

            $token = $request->user()->createToken('@academia', $permissionsUser);

            return $this->response('Autorizado', Response::HTTP_OK, [
                'name' =>  $request->user()->name,
                'profile' => $profile->name,
                'permissions' => $permissionsUser,
                'token' => $token->plainTextToken
            ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
