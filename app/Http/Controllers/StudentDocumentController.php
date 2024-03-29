<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Services\File\CreateFileService;
use App\Models\StudentDocument;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class StudentDocumentController extends Controller
{
    public function storeDocuments(
        StoreDocumentRequest $request,
        CreateFileService $createFileService,
        $id
    ) {
        $data = $request->validated();

        $slug = $request->filled('title') ? Str::slug($request->input("title")) : null;

        $file = $createFileService->handle(
            "student_document",
            $request->file("document"),
            $slug
        );

        $document = StudentDocument::create([
            'title' => $data['title'],
            'file_id' => $file->id,
            'student_id' => $id,
        ]);

        return response()->json(['message' => 'Document created successfully', 'document' => $document], Response::HTTP_OK);
    }
}
