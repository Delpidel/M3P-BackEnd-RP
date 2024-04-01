<?php

namespace App\Http\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;

class StudentRepository implements StudentRepositoryInterface
{
    public function createOne(array $data)
    {
        return Student::create($data);
    }

    public function find($id)
    {
        return Student::find($id);
    }

    public function delete(Student $student)
    {
        return $student->delete();
    }
}
