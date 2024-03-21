<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminDeleteTest extends TestCase
{

    public function test_admin_can_delete_users()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['delete-users'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/users/2');

        $response->assertStatus(204);
    }

    public function test_others_user_can_not_delete_users()
    {
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete('/api/users/2');

        $response->assertStatus(403);
    }

    public function test_user_not_found_in_database()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['delete-users'])->plainTextToken;

        $count = User::count();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->delete("/api/users/" . ($count + 1));

        $response->assertStatus(404);

        $response->assertJson([
            "message" => "O usuário não está cadastrado no banco de dados.",
            "status" => 404,
            "errors" => [],
            "data" => []
        ]);
    }
}
