<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Services\File\CreateFileService;
use App\Http\Services\User\CreateOneUserService;
use App\Http\Services\User\DeleteOneUserService;
use App\Http\Services\User\GetAllUsersService;
use App\Http\Services\User\GetOneUserService;
use App\Http\Services\User\GetOneUserWithFileService;
use App\Http\Services\User\PasswordGenerationService;
use App\Http\Services\User\PasswordHashingService;
use App\Http\Services\User\SendEmailWelcomeService;
use App\Http\Services\User\UpdateOneUserService;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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

    public function show($id, GetOneUserWithFileService $getOneUserWithFileService)
    {
        $user = $getOneUserWithFileService->handle($id);
        return $user;
    }

    public function update(
        $id,
        UpdateUserRequest $request,
        UpdateOneUserService $updateOneUserService,
        GetOneUserService $getOneUserService,
        CreateFileService $createFileService
    ) {
        $user = $getOneUserService->handle($id);
        $body = $request->except('profile_id');

        if ($request->has('photo')) {
            if ($request->hasFile('photo')) {
                $file = $createFileService->handle('photos', $request->file('photo'), $user['name']);
                $body['file_id'] = $file->id;
            } else {
                $body['file_id'] = null;
            }
        }

        $updatedUser = $updateOneUserService->handle($user, $body);
        return $updatedUser;
    }

    public function destroy($id, DeleteOneUserService $deleteOneUserService)
    {
        return $deleteOneUserService->handle($id);
    }
}
