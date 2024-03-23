<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\StudentDocument;
use App\Http\Services\File\CreateFileService;
use App\Http\Controllers\StudentDocumentController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class StudentDocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_creates_document_successfully()
    {
        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $createFileService = $this->createMock(CreateFileService::class);

        $createFileService->expects($this->once())
            ->method('handle')
            ->with(
                $this->anything(),
                $this->identicalTo($file),
                $this->anything()
            )
            ->willReturn(['name' => 'document.pdf', 'size' => 1024, 'mime' => 'pdf', 'url' => 'http://example.com/document.pdf']);

        $controller = new StudentDocumentController($createFileService);

        $request = Request::create('/api/documents', 'POST', [
            'title' => 'Document Title',
            'file_id' => 1
        ]);

        $request->setUserResolver(function () {
            return (object) ['id' => 1];
        });

        $response = $controller->store($request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Document created successfully',
                'document' => [
                    'title' => 'Document Title',
                    'student_id' => 1,
                    'file_id' => 1,
                ]
            ]);
    }
}
