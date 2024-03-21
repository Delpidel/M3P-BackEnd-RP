<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
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

    public function store(StoreUserRequest $request)
    {
        $file = $request->file('photo');
        $body =  $request->input();

        $pathBucket = Storage::disk('s3')->put('photos', $file);
        $fullPathFile = Storage::disk('s3')->url($pathBucket);

        $file = File::create(
            [
                'name' => 'foto_' . $body['name'],
                'size' => $file->getSize(),
                'mime' => $file->extension(),
                'url' => $fullPathFile
            ]
        );

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
