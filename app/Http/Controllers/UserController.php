<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Services\File\CreateFileService;
use App\Mail\SendWelcomeToUser;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private function sendWelcomeEmail(User $user, string $password)
    {
        Mail::to($user->email, $user->name)
            ->send(new SendWelcomeToUser($user->name, $user->profile->name, $password));
    }

    public function store(StoreUserRequest $request, CreateFileService $createFileService)
    {
        $file = $request->file('photo');
        $body =  $request->input();

        $file = $createFileService->handle('photos', $file, $body['name']);

        $password = Str::password(8);
        $hashedPassword = Hash::make($password);

        $user = User::create([
            ...$body,
            'password' => $hashedPassword,
            'file_id' => $file->id
        ]);

        $this->sendWelcomeEmail($user, $password);

        return $user;
    }
}
