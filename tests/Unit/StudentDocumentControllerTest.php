<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Student;
use Database\Factories\StudentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentDocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_documents()
    {
        $student = Student::factory()->create();

        Storage::fake('s3');

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $data = [
            'title' => 'Test Document',
            'document' => $file,
            'student_id' => $student->id,
        ];

        $token = $this->getUserToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/students/1/documents', $data);

        $response->assertStatus(201);

        Storage::disk('s3')->assertExists('studentdocument/' . $file->hashName());

        $this->assertDatabaseHas('files', [
            'name' => 'documento' . $data['title'],
            'size' => $file->getSize(),
            'mime' => $file->extension(),
        ]);

        $this->assertDatabaseHas('student_documents', [
            'title' => $data['title'],
            'student_id' => $data['student_id'],
        ]);
    }

    private function getUserToken(): string
    {
        $receptionist = User::find(2);
        $credentials = [
            'email' => $receptionist->email,
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200);

        return $response->json('data.token');
    }
}
