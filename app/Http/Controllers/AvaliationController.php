<?php

namespace App\Http\Controllers;

use App\Models\Avaliation;
use App\Models\Student;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Response;

class AvaliationController extends Controller
{
    public function index($student_id)
    {
        try {
            $student = Student::findOrFail($student_id);

            // Obtenha apenas as avaliações para esse estudante
            //$evaluations = $student->avaliations;
            $evaluations = Avaliation::where('student_id', $student_id)->get();
            return $evaluations;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }
}
