<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

use App\Http\Services\File\CreateFileService;
use App\Http\Services\User\CreateOneUserService;
use App\Http\Services\User\DeleteOneUserService;
use App\Http\Services\User\GetAllUsersService;
use App\Http\Services\User\PasswordGenerationService;
use App\Http\Services\User\PasswordHashingService;
use App\Http\Services\User\SendEmailWelcomeService;
use App\Models\User;

use App\Traits\HttpResponses;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use HttpResponses;

    public function store(
        StoreUserRequest $request,
        CreateFileService $createFileService,
        PasswordGenerationService $passwordGenerationService,
        PasswordHashingService $passwordHashingService,
        SendEmailWelcomeService $sendEmailWelcomeService,
        CreateOneUserService $createOneUserService
    ) {
        $body = $request->input();

        if ($request->hasFile('photo')) {
            $file = $createFileService->handle('photos', $request->file('photo'), $body['name']);
            $body['file_id'] = $file->id;
        }

        $password = $passwordGenerationService->handle();
        $hashedPassword = $passwordHashingService->handle($password);

        $user = $createOneUserService->handle([...$body, 'password' => $hashedPassword]);
        $sendEmailWelcomeService->handle($user, $password);

        return $user;
    }

    public function index(Request $request, GetAllUsersService $getAllUsersService)
    {
        $search = $request->input('word');

        $users = $getAllUsersService->handle($search);

        return $users;
    }

    public function update(Request $request, $id, CreateFileService $createFileService,)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->error('O usuário não está cadastrado no banco de dados.', Response::HTTP_NOT_FOUND);
        }

        $body = $request->input();

        $request->validate([
            'name' => 'string|max:255|regex:/^[\p{L}\s]+$/u',
            'email' => 'string|email|max:255|unique:users',
            'profile_id' => 'integer|in:2,3,4',
            'photo' => 'file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('photo')) {

            $file = $createFileService->handle('photos', $request->file('photo'), $body['name']);
            $body['file_id'] = $file->id;
        }

        $user->update($body);

        return $user;
    }

    public function destroy($id, DeleteOneUserService $deleteOneUserService)
    {
        return $deleteOneUserService->handle($id);
    }
}
