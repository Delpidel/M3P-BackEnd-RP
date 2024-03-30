<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Tests\TestCase;

class StudentUpdateTest extends TestCase
{
    public function test_receptionist_can_update_all_student_data()
    {
        $receptionist = User::factory()->create(['profile_id' => 2]);
        $student = Student::factory()->create(['id' => 14]);
        $token = $receptionist->createToken('@recepcao', ['update-students'])->plainTextToken;

        $body = [
            'name' => 'Rodrigo Rodrigues',
            'email' => 'newEmail@example.com',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cpf' => '123.456.789-99',
            'cep' => '96810174',
            'city' => 'Santa cruz do sul',
            'neighborhood' => 'Centro',
            'number' => '642',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->put('/api/students/' . $student->id, $body);

        $response->assertStatus(200);
        $response->assertJson([
            ...$student->toArray(),
            'name' => 'Rodrigo Rodrigues',
            'email' => 'newEmail@example.com',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cpf' => '123.456.789-99',
            'cep' => '96810174',
            'city' => 'Santa cruz do sul',
            'neighborhood' => 'Centro',
            'number' => '642',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
        ]);
    }

    public function test_receptionist_cannot_create_with_invalid_name()
    {
        $receptionist = User::factory()->create(['profile_id' => 2]);
        $student = Student::factory()->create(['id' => 14]);
        $token = $receptionist->createToken('@recepcao', ['update-students'])->plainTextToken;

        $body = [
            'name' => '',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->put('/api/students/' . $student->id, $body);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => "The name field must be a string.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_receptionist_cannot_create_with_invalid_cpf()
    {
        $receptionist = User::factory()->create(['profile_id' => 2]);
        $student = Student::factory()->create(['id' => 14]);
        $token = $receptionist->createToken('@recepcao', ['update-students'])->plainTextToken;

        $body = [
            'cpf' => '12345678999',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->put('/api/students/' . $student->id, $body);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => "O campo CPF deve estar no formato válido.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_receptionist_cannot_update_user_email_to_an_existing_one()
    {
        $receptionist = User::factory()->create(['profile_id' => 2]);
        $studentOne = Student::factory()->create(['id' => 14, 'email' => 'student1@example.com']);
        $studentTwo = Student::factory()->create(['id' => 15, 'email' => 'student2@example.com']);
        $token = $receptionist->createToken('@recepcao', ['update-students'])->plainTextToken;

        $body = [
            'email' => $studentTwo->email,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->put('/api/students/' . $studentOne->id, $body);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => "O email informado já está em uso.",
        ]);
    }

    public function test_receptionist_cannot_found_id()
    {
        $receptionist = User::factory()->create(['profile_id' => 2]);
        $token = $receptionist->createToken('@recepcao', ['update-students'])->plainTextToken;

        $nonExistentId = 999;

        $body = [
            'city' => 'Salvador',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->put('/api/students/' . $nonExistentId, $body);

        $response->assertStatus(404);
        $response->assertJson([
            "message" => "O Aluno não foi encontrado no banco de dados.",
            "status" => 404,
            "errors" => [],
            "data" => []
        ]);
    }
}
