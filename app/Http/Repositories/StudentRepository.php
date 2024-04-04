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
    public function getOne($id) {
        return Student::find($id);
    }
    public function updateOne(Student $student, $data) {
        $student->update($data);
        $student->save();
        return $student;

    public function createDocument(Student $student, array $documentData)
    {
        return $student->documents()->create($documentData);
    }
}
