<?php

namespace App\Http\Controllers;
use App\Models\StudentDocument;
use Illuminate\Http\Request;

class StudentDocumentController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validation
        $request->validate([
            'title' => 'nullable|string|max:255',
            'file_id' => 'required|exists:files,id',
        ]);

        // Document creation
        $studentDocument = new StudentDocument();
        $studentDocument->title = $request->input('title');
        $studentDocument->file_id = $request->input('file_id');

        // Associate the document with the student
        $studentDocument->student_id = $id;
        $studentDocument->save();

        // Successful response
        return response()->json([], 200);
    }
}
