<?php

namespace Tests\Feature;

use App\Http\Controllers\StudentController;
use App\Http\Services\Student\DeleteOneStudentService;
use App\Http\Services\Student\ListAllStudentsService;
use App\Mail\CredentialsStudent;
use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentTest extends TestCase
{
    public function test_recepcionist_can_create_student(): void
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('Token recepcionista', ['create-students'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3
        $photo = UploadedFile::fake()->image('photo.jpg');

        $student = [
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'cpf' => '024.892.560-26',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cep' => '96810174',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
            'neighborhood' => 'Centro',
            'city' => 'Santa cruz do sul',
            'number' => '642',
            'complement' => 'Casa amarela',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/students', $student + ['photo' => $photo]);

        Mail::assertSent(CredentialsStudent::class, function ($mail) {
            return $mail->hasTo('joao@example.com');
        });

        $response->assertStatus(201)->assertJson([...$student, 'file_id' => 1]);
    }

    public function test_others_users_cannot_create_student(): void
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('Token', [''])->plainTextToken;

        $photo = UploadedFile::fake()->image('photo.jpg');

        Storage::fake('s3'); // Mock AWS S3

        $student = [
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'cpf' => '024.892.560-26',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cep' => '96810174',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
            'neighborhood' => 'Centro',
            'city' => 'Santa cruz do sul',
            'number' => '642',
            'complement' => 'Casa amarela',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/students', $student + ['photo' => $photo]);

        $response->assertStatus(403)->assertJson(['message' => 'Acesso negado. Você não possui permissão para executar esta ação.']);
    }

    public function test_delete_student_by_authorized_user(): void
    {

        Auth::shouldReceive('id')->once()->andReturn(2);

        $deleteOneStudentServiceMock = \Mockery::mock(DeleteOneStudentService::class);

        $deleteOneStudentServiceMock->shouldReceive('handle')->once()->with(1)->andReturn('success');

        $listAllStudentServiceMock = \Mockery::mock(ListAllStudentsService::class);

        $student = new StudentController($listAllStudentServiceMock);

        $response = $student->destroy(1, $deleteOneStudentServiceMock);

        $this->assertEquals('success', $response);
    }
}
