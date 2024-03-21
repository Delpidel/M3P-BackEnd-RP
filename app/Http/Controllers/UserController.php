<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;

use App\Http\Services\File\CreateFileService;
use App\Http\Services\User\PasswordGenerationService;
use App\Http\Services\User\PasswordHashingService;
use App\Http\Services\User\SendEmailWelcomeService;

use App\Models\User;

use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function store(
        StoreUserRequest $request,
        CreateFileService $createFileService,
        PasswordGenerationService $passwordGenerationService,
        PasswordHashingService $passwordHashingService,
        SendEmailWelcomeService $sendEmailWelcomeService
    ) {
        $file = $request->file('photo');
        $body =  $request->input();

        $file = $createFileService->handle('photos', $file, $body['name']);

        $password = $passwordGenerationService->handle();
        $hashedPassword = $passwordHashingService->handle($password);

        $user = User::create([
            ...$body,
            'password' => $hashedPassword,
            'file_id' => $file->id
        ]);

        $sendEmailWelcomeService->handle($user, $password);

        return $user;
    }
}
