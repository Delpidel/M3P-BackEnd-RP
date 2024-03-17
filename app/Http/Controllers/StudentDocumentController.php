<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentDocumentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'nullable|string|max:255',
                'file' => 'nullable|string|max:255|unique:student_documents,file',
            ]);

            $studentId = auth()->user()->id;

            $document = StudentDocument::create([
                'title' => $data['title'],
                'file' => $data['file'],
                'student_id' => $studentId,
            ]);

            return response()->json(['message' => 'Document created successfully', 'document' => $document], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
