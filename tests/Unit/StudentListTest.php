<?php

namespace Tests\Feature;

use App\Http\Services\Student\ListAllStudentsService;
use App\Models\Student;
use App\Models\User;
use Tests\TestCase;


class StudentListTest extends TestCase
{
    public function test_receptionist_token_was_generated(): void
    {
        $receptionist = User::find(2);
        $credentials = [
            'email' => $receptionist->email,
            'password' => '12345678',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200);
    }
    public function test_can_list_without_parameters(): void
    {

        $token = $this->getUserToken();

        $receptionist = User::find(2);
        $student = Student::factory()->create(['user_id' => $receptionist->id]);

        $queryParams = [
            'name' => NULL,
            'email' => NULL,
            'cpf' => NULL,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/students', $queryParams);

        $response->assertStatus(200);
    }
    public function test_can_list_by_name(): void
    {

        $token = $this->getUserToken();

        $receptionist = User::find(2);
        $student = Student::factory()->create(['user_id' => $receptionist->id]);

        $queryParams = [
            'name' => $student->name,
            'email' => NULL,
            'cpf' => NULL,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/students', $queryParams);

        $response->assertStatus(200);
    }
    public function test_can_list_by_cpf(): void
    {
        $token = $this->getUserToken();

        $receptionist = User::find(2);
        $student = Student::factory()->create(['user_id' => $receptionist->id]);

        $queryParams = [
            'name' => NULL,
            'email' => NULL,
            'cpf' => $student->cpf,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/students', $queryParams);

        $response->assertStatus(200);
    }
    public function test_can_list_by_email(): void
    {
        $token = $this->getUserToken();

        $receptionist = User::find(2);
        $student = Student::factory()->create(['user_id' => $receptionist->id]);

        $queryParams = [
            'name' => null,
            'email' => $student->email,
            'cpf' => null,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/students', $queryParams);

        $response->assertStatus(200);
    }
    public function test_can_not_list_without_token()
    {
        $queryParams = [
            'name' => null,
            'email' => NULL,
            'cpf' => null,
        ];

        $response = $this->getJson('/api/students', $queryParams);

        $response->assertStatus(401);
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