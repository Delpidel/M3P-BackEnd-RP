<?php

namespace App\Http\Services\User;

use App\Http\Repositories\UserRepository;
use App\Traits\HttpResponses;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GetAllUsersService
{
    use HttpResponses;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($search)
    {

        $user_id = Auth::user()->id;

        if ($user_id !== 1) {
            return $this->error('O usuário não tem permissão para visualizar essa informação.', Response::HTTP_NOT_FOUND);
        }

        $users = $this->userRepository->getAll($search);

        $usersWithProfiles = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile' => $user->profile->name,
                'is_active' => $user->is_active,
            ];
        });

        return $usersWithProfiles;
    }
}
