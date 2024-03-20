<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Mail\CredentialsStudent;


use App\Models\Student;
use App\Models\UserStudent;

use Illuminate\Support\Str;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;

    public function store(StoreStudentRequest $request)
    {
        try {
            $body = $request->validated();

            // Gerar senha aleatória
            $password = Str::random(8);

            // Obtém o ID do usuário autenticado
            $userId = auth()->user()->id;

            // Cria o estudante
            $student = Student::create($body);

            // Vincula o estudante ao usuário na tabela intermediária
            UserStudent::create([
                'user_id' => $userId,
                'student_id' => $student->id,
            ]);
            // Enviar email com as credenciais
            Mail::to($student->email)->send(new CredentialsStudent($student, $password));

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}