<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStudentsRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Services\File\CreateFileService;
use App\Http\Services\Student\CreateOneStudentService;
use App\Http\Services\Student\DeleteOneStudentService;
use App\Http\Services\Student\ListAllStudentsService;
use App\Http\Services\Student\PasswordGenerationService;
use App\Http\Services\Student\PasswordHashingService;
use App\Http\Services\Student\SendCredentialsStudentEmail;
use App\Http\Services\Student\UpdateOneStudentService;
use App\Http\Services\User\CreateOneUserService;
use App\Http\Services\UserStudent\CreateOneUserStudentService;
use Illuminate\Support\Str;

use App\Models\Student;
use App\Models\File;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;
    
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

    public function update($id,
    UpdateStudentRequest $request,
    UpdateOneStudentService $updateOneStudentService)
    {
        $body = $request->all();
        $student =  $updateOneStudentService->handle($id, $body);
        return $student;
    }

    public function destroy($id, DeleteOneStudentService $deleteOneStudentService)
    {
        $userId = Auth::id();

        if ($userId != 2) {
            return $this->error('Usuário logado não pode excluir estudante', Response::HTTP_FORBIDDEN);
        }

        return $deleteOneStudentService->handle($id);
    }
}
