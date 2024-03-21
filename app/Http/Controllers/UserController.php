<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'string|required|email|max:255|unique:users',
            'profile_id' => 'integer|required',
            'photo' => 'file|mimes:jpeg,png,jpg,gif,svg',
        ]);

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
        return $user;
    }



    // $file = $createFileService->handle('photos', $file, $body['name']);
    // $pet = $createOnePetService->handle([...$body, 'file_id' => $file->id]);

    // $sendEmailWelcomeService->handle($pet);

    // return $pet;

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'name' => 'required|unique:species|max:50'
    //         ]);

    //         $body = $request->all();
    //         $specie = Specie::create($body);
    //         return $specie;
    //     } catch (\Exception $exception) {
    //         return $this->error($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }
}
