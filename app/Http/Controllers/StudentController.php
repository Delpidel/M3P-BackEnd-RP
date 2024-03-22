<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Services\File\CreateFileService;

use App\Mail\CredentialsStudent;


use App\Models\Student;
use App\Models\User;
use App\Models\UserStudent;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;

    public function store(StoreStudentRequest $request, CreateFileService $createFileService)
    {
        try {

            DB::beginTransaction();

            $file = $request->file('photo');

            $body = $request->all();

            $file = $createFileService->handle('photos', $file, $body['name']);

            $password = Str::password(8);

            $passwordHashed = Hash::make($password);

            $student = Student::create($body);

            $user = User::create([
                'name' => $body['name'],
                'email' => $body['email'],
                'password' => $passwordHashed,
                'file_id' => $file->id,
                'profile_id' => 5,
            ]);

            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $student->id,
            ]);

            Mail::to($student->email)->send(new CredentialsStudent($student, $password));

            DB::commit();

            return $student;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
