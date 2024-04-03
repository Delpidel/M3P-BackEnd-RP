<?php

namespace App\Http\Controllers;

use App\Models\Avaliation;
use Symfony\Component\HttpFoundation\Response;

class AvaliationController extends Controller
{
    public function index()
    {
        try {

            $students = Avaliation::all();
            return $students;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }
}
