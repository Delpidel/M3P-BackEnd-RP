<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;

use App\Http\Services\File\CreateFileService;
use App\Http\Services\User\PasswordGenerationService;
use App\Http\Services\User\PasswordHashingService;

use App\Mail\SendWelcomeToUser;

use App\Models\User;

use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    private function sendWelcomeEmail(User $user, string $password)
    {
        Mail::to($user->email, $user->name)
            ->send(new SendWelcomeToUser($user->name, $user->profile->name, $password));
    }

    public function store(
        StoreUserRequest $request,
        CreateFileService $createFileService,
        PasswordGenerationService $passwordGenerationService,
        PasswordHashingService $passwordHashingService
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

        $this->sendWelcomeEmail($user, $password);

        return $user;
    }
}
