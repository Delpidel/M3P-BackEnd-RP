<?php

namespace App\Http\Services\Student;

use App\Mail\CredentialsStudent;
use Illuminate\Support\Facades\Mail;

use App\Models\Student;

class SendCredentialsStudentEmailService
{
    public function handle(Student $student, string $password)
    {
        Mail::to($student->email)->send(new CredentialsStudent($student, $password));
    }
}
