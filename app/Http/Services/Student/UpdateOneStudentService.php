<?php

namespace App\Http\Services\Student;

use App\Http\Repositories\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HttpResponses;

use ErrorException;

class UpdateOneStudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function handle($id, $data)
    {
        $student = $this->studentRepository->getOne($id);

        if(!$student) throw new ErrorException('Aluno não encontrado', Response::HTTP_NOT_FOUND);

        return $this->studentRepository->updateOne($student, $data);
    }
}
