<?php

namespace Tests\Feature;

use App\Mail\SendEvaluationEmail;
use App\Models\Avaliation;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NutricionistStudentSendTest extends TestCase
{
    public function test_nutricionist_can_send_avaliation(): void
    {
        Mail::fake();

        $student = Student::factory()->create();
        $avaliation = Avaliation::factory()->create(['student_id' => $student->id]);

        $user = User::factory()->create(['profile_id' => 4, 'password' => '12345678']);

        $response = $this->actingAs($user)->get("/avaliations/send/$avaliation->id");

        Mail::assertSent(SendEvaluationEmail::class, function ($mail) {
            return $mail;
        });

        $response->assertStatus(200);
    }
}
