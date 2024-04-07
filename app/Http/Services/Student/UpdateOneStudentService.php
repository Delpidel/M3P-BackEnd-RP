<?php

namespace App\Http\Services\Student;

use App\Http\Repositories\StudentRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HttpResponses;


class UpdateOneStudentService
{
    use HttpResponses;

    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function handle($id, $data)
    {
        $student = $this->studentRepository->getOne($id);

        if (!$student) {
            return $this->error('O Aluno não foi encontrado no banco de dados.', Response::HTTP_NOT_FOUND);
        }

        return $this->studentRepository->updateOne($student, $data);
    }
}
