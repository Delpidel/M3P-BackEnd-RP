<?php

namespace App\Http\Controllers;

use App\Mail\SendEvaluationEmail;
use App\Models\Avaliation;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class StudentExportController extends Controller
{
    use HttpResponses;

    public function index (Request $request) {

        $user_id = $request->user();

        if(!$user_id) {
            return $this->response("Usuário não autenticado", Response::HTTP_UNAUTHORIZED);
        }

        $active_students = $user_id->orderby('name')->get();

        Mail::to('ingrid.mariane.araujo@gmail.com', 'Ingrid')
        ->send(new SendEvaluationEmail($active_students->name));

        return $active_students;

    }

    public function export ($id){

        // $user = $request->user();

        // $students = $user->students()->findOrFail($id);

        // $student_name = $students->name;

        $avaliations = Avaliation::where('student_id', $id)->get();

        // $avaliations = Avaliation::all();

        $pdf = Pdf::loadView('pdfs.Evaluations', [
            // 'students' => $students,
            'avaliations' => $avaliations]);

        return $pdf->stream('Evaluations.pdf');

    }

}

