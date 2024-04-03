<?php

namespace App\Interfaces;

use App\Models\Student;

interface StudentRepositoryInterface
{
    public function createOne(array $data);
    public function createDocument(Student $student, array $documentData);
}
