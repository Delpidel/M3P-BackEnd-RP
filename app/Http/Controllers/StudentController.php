<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\UserStudent;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        try {
            $body = $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'string|required|email|max:255|unique:students',
                'date_birth' => 'nullable|date_format:Y-m-d',
                'contact' => 'string|required|max:20',
                'cpf' => 'nullable|unique:students|regex:/^(?:\d{3}\.\d{3}\.\d{3}-\d{2}|\d{11})$/',
                'cep' => 'nullable|string|max:20',
                'street' => 'required|string',
                'state' => 'required|string|max:2',
                'neighborhood' => 'required|string',
                'city' => 'required|string',
                'number' => 'required|string',
            ]);

            // Verifica se há um usuário autenticado
            if (Auth::check()) {
                // Obtém o ID do usuário autenticado
                $userId = Auth::id();

                // Cria o estudante associado ao usuário autenticado
                $student = Student::create($body);

                // Vincula o estudante ao usuário na tabela intermediária
                UserStudent::create([
                    'user_id' => $userId,
                    'student_id' => $student->id,
                ]);

                return $student;
            } else {
                // Retorna erro se não houver usuário autenticado
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
