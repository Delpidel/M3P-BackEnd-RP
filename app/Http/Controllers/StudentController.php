<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;

use App\Mail\CredentialsStudentEmail;

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
            $body = $request->validate();

            // Verifica se há um usuário autenticado
            if (Auth::check()) {
                // Obtém o ID do usuário autenticado
                $userId = Auth::id();

                // Cria o estudante associado ao usuário autenticado
                $student = Student::create($body);

                $password = Str::random(8); // Gerar senha aleatória
                Mail::to($student->email)->send(new CredentialsStudentEmail($student, $password));

                // Vincula o estudante ao usuário na tabela intermediária
                UserStudent::create([
                    'user_id' => $userId,
                    'student_id' => $student->id,
                ]);

                return $student;
            }
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}