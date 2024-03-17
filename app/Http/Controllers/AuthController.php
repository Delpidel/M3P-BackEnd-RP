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
            'get-students',
            'get-workouts'
        ],
        'RECEPCIONISTA' => [
            'get-students',
            'get-workouts'
        ],
        'INSTRUTOR' => [
            'get-students',
            'get-workouts'
        ],
        'NUTRICIONISTA' => [
            'get-students',
            'get-workouts'
        ],
        'ALUNO' => [
            'get-students',
            'get-workouts'
        ]
    ];

    public function store(Request $request)
    {
        try {
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
                'token' => $token->plainTextToken,
                'permissions' => $permissionsUser,
                'name' =>  $request->user()->name,
                'profile' => $profile->name
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
