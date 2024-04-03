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

            $students = Avaliation::all();
            return $students;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }
}
