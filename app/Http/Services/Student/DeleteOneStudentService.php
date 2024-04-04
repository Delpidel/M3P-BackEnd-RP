<?php

namespace App\Http\Services\Student;

use App\Models\Student;
use Illuminate\Http\Response;

class DeleteOneStudentService
{
    public function handle($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}