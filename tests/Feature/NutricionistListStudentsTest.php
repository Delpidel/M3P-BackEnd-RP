<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NutricionistListStudentsTest extends TestCase
{
    public function test_nutricionist_can_list_students(): void
    {
        Student::factory()->create();

        $user = User::factory()->create(['profile_id' => 4, 'password' => '12345678']);

        $response = $this->actingAs($user)->get('/students');

        $response->assertStatus(200);
    }
}
