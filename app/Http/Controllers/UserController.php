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

use App\Traits\HttpResponses;

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
        $body =  $request->input();

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

    public function destroy($id, DeleteOneUserService $deleteOneUserService)
    {

        return $deleteOneUserService->handle($id);
    }
}
