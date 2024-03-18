<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
                'cpf' => 'nullable|unique:students|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$|regex:/^\d{11}$/',
                'cep' => 'nullable|string|max:20',
                'street' => 'required|string',
                'state' => 'required|string|max:2',
                'neighborhood' => 'required|string',
                'city' => 'required|string',
                'number' => 'required|string',
            ]);

            $student = Student::create($body);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
