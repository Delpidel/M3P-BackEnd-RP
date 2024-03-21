<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;

use App\Http\Services\File\CreateFileService;
use App\Http\Services\User\CreateOneUserService;
use App\Http\Services\User\PasswordGenerationService;
use App\Http\Services\User\PasswordHashingService;
use App\Http\Services\User\SendEmailWelcomeService;

use App\Models\User;


class UserController extends Controller
{
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
}
