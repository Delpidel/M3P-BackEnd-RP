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
    public function delete(Student $student)
    {
        return $student->delete();
    }

    public function search($name, $email, $cpf)
    {
        return Student::where(function ($query) use ($name, $email, $cpf) {
            if ($name !== null) {
                $query->where('name', 'like', '%' . $name . '%');
            }
            if ($email !== null) {
                $query->orWhere('email', 'like', '%' . $email . '%');
            }
            if ($cpf !== null) {
                $query->orWhere('cpf', 'like', '%' . $cpf . '%');
            }
        })
            ->orderBy('name')
            ->orderBy('id') // Ordenar por ID para garantir uma ordem determinística
            ->get(['id', 'name', 'email', 'contact', 'cpf']);
    }
    public function createDocument(Student $student, array $documentData)
    {
        return $student->documents()->create($documentData);
    }
}
