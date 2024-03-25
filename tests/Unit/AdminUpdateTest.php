<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_can_update_user_photo()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3

        $body = [
            'photo' => UploadedFile::fake()->image('new_photo.jpg')
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(200)->assertJson([
            ...$user->toArray(),
            'file_id' => $response['file_id']
        ]);
    }

    public function test_admin_can_update_all_user_data()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3

        $body = [
            'name' => 'New Name',
            'email' => 'newemail@test.com',
            'photo' => UploadedFile::fake()->image('new_photo.jpg')
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(200)->assertJson([
            ...$user->toArray(),
            'name' => 'New Name',
            'email' => 'newemail@test.com',
            'file_id' => $response['file_id']
        ]);
    }

    public function test_admin_can_not_update_without_valid_name()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'name' => '',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(400)->assertJson(['message' => 'O campo name deve ser uma string válida']);
    }

    public function test_admin_can_not_update_without_valid_email()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'email' => 'invalidemail',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(400)->assertJson(['message' => 'O campo email deve conter um email válido']);
    }

    public function test_admin_can_not_update_without_valid_file_type()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        Storage::fake('s3'); // Mock AWS S3

        $body = [
            'photo' => UploadedFile::fake()->create('new_photo.pdf')
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(400)->assertJson(['message' => 'O campo photo deve ser um arquivo do tipo: jpeg, png, jpg, gif, svg']);
    }

    public function test_admin_can_not_update_user_email_to_an_existing_one()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $user2 = User::factory()->create(['profile_id' => 3]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'email' => $user2->email,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(400)->assertJson(['message' => 'Este email já foi cadastrado']);
    }

    public function test_admin_can_not_update_user_profile_id()
    {
        $admin = User::factory()->create(['profile_id' => 1]);
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $admin->createToken('@academia', ['update-users'])->plainTextToken;

        $body = [
            'name' => 'New Name',
            'profile_id' => 3,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(200)->assertJson([
            ...$user->toArray(),
            'name' => 'New Name',
            'profile_id' => 2 //O profile_id não é alterado, apesar do status 200
        ]);
    }

    public function test_others_users_cannot_update_user()
    {
        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('@academia', [''])->plainTextToken;

        $body = [
            'name' => 'New Name',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->put('/api/users/' . $user->id, $body);

        $response->assertStatus(403)->assertJson(['message' => 'Acesso negado. Você não possui permissão para executar esta ação.']);
    }
}