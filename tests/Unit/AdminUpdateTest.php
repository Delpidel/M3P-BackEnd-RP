<?php

namespace Tests\Feature;

use App\Models\User;

use Tests\TestCase;

class AdminUpdateTest extends TestCase
{
    public function test_admin_can_update_user_name()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'name' => 'New Name',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(200)->assertJson([
            ...$user->toArray(),
            'name' => 'New Name'
        ]);
    }

    public function test_admin_can_update_user_email()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'email' => 'newemail@test.com',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(200)->assertJson([
            ...$user->toArray(),
            'email' => 'newemail@test.com'
        ]);
    }
}
