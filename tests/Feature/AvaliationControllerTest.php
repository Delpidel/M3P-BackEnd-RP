<?php

namespace Tests\Feature;

use App\Models\Avaliation;
use App\Models\File;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Str;

class AvaliationControllerTest extends TestCase
{
    // Remove the line below
    // public function test_store_method_stores_avaliation_and_files()
    // {
    //     // Create a user
    //     $user = User::factory()->create(['profile_id' => 4]);
    //     // Authenticate user
    //     Sanctum::actingAs($user, ['create-avaliations']);
    //     // Generate token
    //     $token = $user->createToken('@academia', ['create-avaliations'])->plainTextToken;
    //     // Simulate file upload to AWS S3 for file1 (front)
    //     Storage::fake('s3');
    //     $file1 = UploadedFile::fake()->image('front.jpg');

    //     // Store file in AWS S3 and get URL and ID for file1 (front)
    //     $file1Url = Storage::disk('s3')->put('images/' . $file1->getClientOriginalName(), file_get_contents($file1));
    //     $file1Name = $file1->getClientOriginalName();
    //     $file1Size = $file1->getSize();
    //     $file1MimeType = $file1->getMimeType();

    //     // Generate unique ID for file1 (front)
    //     $file1Id = rand(0, 10);

    //     // Save file data to files table for file1 (front)
    //     File::create([
    //         'id' => $file1Id,
    //         'name' => $file1Name,
    //         'size' => $file1Size,
    //         'mime' => $file1MimeType,
    //         'url' => $file1Url,
    //     ]);

    //     Storage::fake('s3');
    //     $file2 = UploadedFile::fake()->image('back.jpg');

    //     // Store file in AWS S3 and get URL and ID for file2 (back)
    //     $file2Url = Storage::disk('s3')->put('images/' . $file2->getClientOriginalName(), file_get_contents($file2));
    //     $file2Name = $file2->getClientOriginalName();
    //     $file2Size = $file2->getSize();
    //     $file2MimeType = $file2->getMimeType();

    //     // Generate unique ID for file2 (back)
    //     $file2Id = rand(0, 10);

    //     // Save file data to files table for file2 (back)
    //     File::create([
    //         'id' => $file2Id,
    //         'name' => $file2Name,
    //         'size' => $file2Size,
    //         'mime' => $file2MimeType,
    //         'url' => $file2Url,
    //     ]);

    //     // Simulate file upload to AWS S3 for file3 (left)
    //     $file3 = UploadedFile::fake()->image('left.jpg');

    //     // Store file in AWS S3 and get URL and ID for file3 (left)
    //     $file3Url = Storage::disk('s3')->put('images/' . $file3->getClientOriginalName(), file_get_contents($file3));
    //     $file3Name = $file3->getClientOriginalName();
    //     $file3Size = $file3->getSize();
    //     $file3MimeType = $file3->getMimeType();

    //     // Generate unique ID for file3 (left)
    //     $file3Id = rand(0, 10);

    //     // Save file data to files table for file3 (left)
    //     File::create([
    //         'id' => $file3Id,
    //         'name' => $file3Name,
    //         'size' => $file3Size,
    //         'mime' => $file3MimeType,
    //         'url' => $file3Url,
    //     ]);

    //     // Simulate file upload to AWS S3 for file4 (right)
    //     $file4 = UploadedFile::fake()->image('right.jpg');

    //     // Store file in AWS S3 and get URL and ID for file4 (right)
    //     $file4Url = Storage::disk('s3')->put('images/' . $file4->getClientOriginalName(), file_get_contents($file4));
    //     $file4Name = $file4->getClientOriginalName();
    //     $file4Size = $file4->getSize();
    //     $file4MimeType = $file4->getMimeType();

    //     // Generate unique ID for file4 (right)
    //     $file4Id = rand(0, 10);

    //     // Save file data to files table for file4 (right)
    //     File::create([
    //         'id' => $file4Id,
    //         'name' => $file4Name,
    //         'size' => $file4Size,
    //         'mime' => $file4MimeType,
    //         'url' => $file4Url,
    //     ]);

    //     // Create a student
    //     $student = Student::factory()->create();

    //     // Prepare data for request
    //     $data = [
    //         'student_id' => $student->id,
    //         'age' => fake()->numberBetween(18, 60),
    //         'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
    //         'weight' => fake()->randomFloat(2, 40, 100),
    //         'height' => fake()->randomFloat(2, 1, 2),
    //         'observations_to_student' => fake()->sentence,
    //         'observations_to_nutritionist' => fake()->sentence,
    //         'back' => $file2Id,
    //         'front' => $file1Id,
    //         'left' => $file3Id,
    //         'right' => $file4Id,
    //         'torax' => fake()->randomFloat(2, 50, 200),
    //         'braco_direito' => fake()->randomFloat(2, 20, 50),
    //         'braco_esquerdo' => fake()->randomFloat(2, 20, 50),
    //         'cintura' => fake()->randomFloat(2, 50, 200),
    //         'antebraco_direito' => fake()->randomFloat(2, 15, 30),
    //         'antebraco_esquerdo' => fake()->randomFloat(2, 15, 30),
    //         'abdomen' => fake()->randomFloat(2, 50, 200),
    //         'coxa_direita' => fake()->randomFloat(2, 30, 80),
    //         'coxa_esquerda' => fake()->randomFloat(2, 30, 80),
    //         'quadril' => fake()->randomFloat(2, 50, 200),
    //         'panturrilha_direita' => fake()->randomFloat(2, 20, 50),
    //         'panturrilha_esquerda' => fake()->randomFloat(2, 20, 50),
    //         'punho' => fake()->randomFloat(2, 10, 30),
    //         'biceps_femoral_direito' => fake()->randomFloat(2, 20, 50),
    //         'biceps_femoral_esquerdo' => fake()->randomFloat(2, 20, 50),
    //     ];

    //     // Make request
    //     $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/avaliations', $data);
    //     dd($response->getContent());
    // }

    // Test for file upload to AWS S3 and database
    public function test_file_upload_to_s3_and_database()
    {
        // Simulate file upload to AWS S3
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('test.jpg');

        // Store file in AWS S3 and get URL and ID
        $fileUrl = Storage::disk('s3')->putFile('images', $file);
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileMimeType = $file->getMimeType();

        // Save file data to files table
        File::create([
            'name' => $fileName,
            'size' => $fileSize,
            'mime' => $fileMimeType,
            'url' => $fileUrl,
        ]);

        // Check if the file is correctly stored in AWS S3
        Storage::disk('s3')->assertExists($fileUrl);

        // Check if file data is correctly stored in files table
        $this->assertDatabaseHas('files', [
            'name' => $fileName,
            'size' => $fileSize,
            'mime' => $fileMimeType,
            'url' => $fileUrl,
        ]);
    }
}
