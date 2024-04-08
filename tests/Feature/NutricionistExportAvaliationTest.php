<?php

namespace Tests\Feature;

use App\Models\Avaliation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NutricionistExportAvaliationTest extends TestCase
{

    public function test_nutricionist_can_export_avaliation(): void
    {
        $student = Student::factory()->create();
        $avaliation = Avaliation::factory()->create(['student_id' => $student->id]);

        $user = User::factory()->create(['profile_id' => 4, 'password' => '12345678']);

        $response = $this->actingAs($user)->get("/avaliations/export/$avaliation->id");

        $response->assertStatus(200);
    }
}
