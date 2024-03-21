<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class AdminListTest extends TestCase
{
    public function test_admin_can_list_all_users()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['get-users'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/users');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'profile',
                'is_active'
            ]
        ]);
    }

    public function test_others_user_can_not_list_all_users()
    {
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/users');

        $response->assertStatus(403);
    }
}
