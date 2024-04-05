<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Services\File\CreateFileService;
use App\Models\File;
use App\Models\StudentDocument;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Response;

class StudentDocumentController extends Controller
{


    public function storeDocuments(StoreDocumentRequest $request, $id)
    {
        $studentId = $id;

        $body = $request->validated();

        $file = $request->file('document');
        $pathBucket = Storage::disk('s3')->put('studentdocument', $file);
        $fullPathFile = Storage::disk('s3')->url($pathBucket);

        $file = File::create([
            'name' => 'documento' . $body['title'],
            'size' => $file->getSize(),
            'mime' => $file->extension(),
            'url' => $fullPathFile
        ]);

        $body['student_id'] = $studentId;

        return StudentDocument::create($body + ['file_id' => $file->id]);

    }
    public function index($id)

    {
        $documents = StudentDocument::where('student_id', $id)->get();
        if ($documents->isEmpty()) {
            return response()->json(['message' => 'Nenhum documento encontrado para este aluno.'], 404);
        }
        return response()->json($documents, 200);
    }
}
