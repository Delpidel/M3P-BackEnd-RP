<?php

namespace App\Http\Controllers;

use App\Mail\SendEvaluationEmail;
use App\Models\Avaliation;
use App\Models\Student;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class StudentExportController extends Controller
{
    use HttpResponses;

    public function index (Request $request, $id) {

        $user_id = $request->user();

        if(!$user_id) {
            return $this->response("Usuário não autenticado", Response::HTTP_UNAUTHORIZED);
        }

        $avaliation = Avaliation::query()->where('id', $id)->first();

        $student = Student::find($avaliation->student_id);

        Mail::to($student->email, $student->name)
        ->send(new SendEvaluationEmail($student->name, date('d-m-Y', strtotime($avaliation->date))));

    }

    public function export (Request $request, $id){

        $user_id = $request->user();

        if (!$user_id) {
            return $this->response('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
        }

        $avaliation = Avaliation::query()->where('id', $id)->first();

        $student = Student::find($avaliation->student_id);

        $pdf = Pdf::loadView('pdfs.Evaluations', [
            'student' => $student,
            'avaliation' => $avaliation]);

        return $pdf->stream('Evaluations.pdf');

    }

}

