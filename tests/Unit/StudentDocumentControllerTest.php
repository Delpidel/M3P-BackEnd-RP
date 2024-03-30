<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\StudentDocumentController;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Services\File\CreateFileService;
use App\Models\StudentDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentDocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_documents(): void
    {
        Storage::fake('s3');

        $file = UploadedFile::fake()->create('document.pdf');

        $requestData = [
            'title' => 'Test Document',
            'document' => $file,
        ];

        $request = $this->getMockBuilder(StoreDocumentRequest::class)
                        ->onlyMethods(['validated'])
                        ->getMock();

        $request->expects($this->once())
                ->method('validated')
                ->willReturn($requestData);

        $createFileService = $this->getMockBuilder(CreateFileService::class)
                                  ->disableOriginalConstructor()
                                  ->onlyMethods(['handle'])
                                  ->getMock();

        $createFileService->expects($this->once())
                          ->method('handle')
                          ->willReturn((object)['id' => 1]);

        $student_id = 1;

        $controller = new StudentDocumentController();

        $response = $controller->storeDocuments($request, $createFileService, $student_id);

        $response->assertJson([
            'message' => 'Document created successfully',
            'document' => [
                'title' => 'Test Document',
                'file_id' => 1,
                'student_id' => $student_id,
            ],
        ])->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('student_documents', [
            'title' => 'Test Document',
            'file_id' => 1,
            'student_id' => $student_id,
        ]);
    }
}
