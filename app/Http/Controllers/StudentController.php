<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStudentsRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Services\File\CreateFileService;
use App\Http\Services\Student\CreateOneStudentService;
use App\Http\Services\Student\ListAllStudentsService;
use App\Http\Services\Student\PasswordGenerationService;
use App\Http\Services\Student\PasswordHashingService;
use App\Http\Services\Student\SendCredentialsStudentEmail;
use App\Http\Services\User\CreateOneUserService;
use App\Http\Services\UserStudent\CreateOneUserStudentService;

class StudentController extends Controller
{
    protected $listAllStudentsService;

    public function __construct(ListAllStudentsService $listAllStudentsService)
    {
        $this->listAllStudentsService = $listAllStudentsService;
    }

    public function index(GetStudentsRequest $request)
    {

        $search = $request->input('search');

        $students = $this->listAllStudentsService->handle($search);

        if ($students->isEmpty()) {
            return response()->json(['message' => 'Nenhum estudante encontrado.'], 404);
        }

        return response()->json($students, 200);
    }

    public function store(
        StoreStudentRequest $request,
        CreateFileService $createFileService,
        CreateOneStudentService $createOneStudentService,
        PasswordGenerationService $passwordGenerationService,
        PasswordHashingService $passwordHashingService,
        SendCredentialsStudentEmail $sendCredentialsStudentEmail,
        CreateOneUserService $createOneUserService,
        CreateOneUserStudentService $createOneUserStudentService
    ) {

        $file = $request->file('photo');

        $body = $request->all();

        $file = $createFileService->handle('photos', $file, $body['name']);

        $password = $passwordGenerationService->handle();

        $passwordHashed = $passwordHashingService->handle($password);

        $student = $createOneStudentService->handle([...$body, 'file_id' => $file->id]);

        $user = $createOneUserService->handle([...$body, 'password' => $passwordHashed]);

        $createOneUserStudentService->handle(['user_id' => $user->id, 'student_id' => $student->id]);

        $sendCredentialsStudentEmail->handle($student, $password);

        return $student;
    }
}
