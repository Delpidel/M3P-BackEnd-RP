<?php

namespace Tests\Feature;

use App\Mail\SendWelcomeToNewUser;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCreateTest extends TestCase
{
    public function test_admin_can_create_user_recepcionista()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        $recepcionista = [
            'name' => 'Recepcionista',
            'email' => 'recep@test.com',
            'profile_id' => 2,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $recepcionista);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('recep@test.com');
        });

        $response->assertStatus(201)->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'created_at', 'updated_at']);
    }

    public function test_admin_can_create_user_recepcionista_with_image()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        Storage::fake('s3');

        $recepcionista = [
            'name' => 'Recepcionista',
            'email' => 'recep@test.com',
            'profile_id' => 2,
            'password' => '12345678',
            'photo' => UploadedFile::fake()->image('recepcionista.jpg') // Mock do upload do arquivo
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $recepcionista);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('recep@test.com');
        });

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'file_id', 'created_at', 'updated_at']);
    }

    public function test_others_users_cannot_create_user_recepcionista()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $recepcionista = [
            'name' => 'Recepcionista',
            'email' => 'recep@test.com',
            'profile_id' => 2,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $recepcionista);

        $response->assertStatus(403)->assertJson(['message' => 'Acesso negado. Você não possui permissão para executar esta ação.']);
    }

    public function test_admin_can_create_user_instrutor()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        $instrutor = [
            'name' => 'Instrutor',
            'email' => 'instrutor@test.com',
            'profile_id' => 3,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $instrutor);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('instrutor@test.com');
        });

        $response->assertStatus(201)->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'created_at', 'updated_at']);
    }

    public function test_admin_can_create_user_instrutor_with_image()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3

        $instrutor = [
            'name' => 'Instrutor',
            'email' => 'instrutor@test.com',
            'profile_id' => 3,
            'password' => '12345678',
            'photo' => UploadedFile::fake()->image('instrutor.jpg') // Mock do upload do arquivo
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $instrutor);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('instrutor@test.com');
        });

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'file_id', 'created_at', 'updated_at']);
    }

    public function test_others_users_cannot_create_user_instrutor()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $instrutor = [
            'name' => 'Instrutor',
            'email' => 'instrutor@test.com',
            'profile_id' => 3,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $instrutor);

        $response->assertStatus(403)->assertJson(['message' => 'Acesso negado. Você não possui permissão para executar esta ação.']);
    }

    public function test_admin_can_create_user_nutricionista()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        $nutricionista = [
            'name' => 'Nutricionista',
            'email' => 'nutricionista@test.com',
            'profile_id' => 4,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $nutricionista);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('nutricionista@test.com');
        });

        $response->assertStatus(201)->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'created_at', 'updated_at']);
    }

    public function test_admin_can_create_user_nutricionista_with_image()
    {
        Mail::fake();

        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['create-users'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3

        $nutricionista = [
            'name' => 'Nutricionista',
            'email' => 'nutricionista@test.com',
            'profile_id' => 4,
            'password' => '12345678',
            'photo' => UploadedFile::fake()->image('nutricionista.jpg') // Mock do upload do arquivo
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $nutricionista);

        Mail::assertSent(SendWelcomeToNewUser::class, function ($mail) {
            return $mail->hasTo('nutricionista@test.com');
        });

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'profile_id', 'file_id', 'created_at', 'updated_at']);
    }

    public function test_others_users_cannot_create_user_nutricionista()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $nutricionista = [
            'name' => 'Nutricionista',
            'email' => 'nutricionista@test.com',
            'profile_id' => 4,
            'password' => '12345678',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/users', $nutricionista);

        $response->assertStatus(403)->assertJson(['message' => 'Acesso negado. Você não possui permissão para executar esta ação.']);
    }
}