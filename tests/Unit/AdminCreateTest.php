<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCreateTest extends TestCase
{
    public function test_admin_can_create_user_recepcionista()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        $recepcionista = [
            'name' => 'Recepcionista',
            'email' => 'recep@test.com',
            'profile_id' => 2,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $recepcionista);

        $response->assertStatus(201)->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'created_at', 'updated_at']);
    }
}
