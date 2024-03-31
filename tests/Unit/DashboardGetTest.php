<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardGetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_get_dashboard()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['get-dashboard'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/dashboard/admin');

        $response->assertStatus(200)->assertJsonStructure([
            'message',
            'status',
            'data' => [
                'registered_exercises',
                'profiles' => [
                    'ADMIN',
                    'ALUNO',
                    'INSTRUTOR',
                    'NUTRICIONISTA',
                    'RECEPCIONISTA',
                ],
                'exercises' => [
                    '*' => [
                        'id',
                        'description',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);    
    }

    public function test_others_users_can_not_get_dashboard()
    {
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/dashboard/admin');

        $response->assertStatus(403);
    }
}
