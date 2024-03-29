<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\StudentDocumentController;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Services\File\CreateFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentDocumentControllerTest extends TestCase
{
    public function test_store_documents()
    {
        $studentId = 1;

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $request = StoreDocumentRequest::create('/api/students/'.$studentId.'/documents', 'POST', [
            'title' => 'Document Title',
            'file_id' => 1,
            'document' => $file,
        ]);

        $createFileService = new CreateFileService();

        $controller = new StudentDocumentController();

        $response = $controller->storeDocuments($request, $createFileService, $studentId);

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = $response->getData(true);
        $this->assertArrayHasKey('document', $responseData);
        $this->assertEquals('Document Title', $responseData['document']['title']);

        Storage::disk('s3')->assertExists('path/to/created/file.pdf');
    }
}
