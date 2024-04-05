<?php

namespace App\Http\Services\Student;

use App\Http\Repositories\StudentRepository;

class ListAllStudentsService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function handle($name = null, $email = null, $cpf = null)
    {
        return $this->studentRepository->search($name, $email, $cpf);
    }
}   