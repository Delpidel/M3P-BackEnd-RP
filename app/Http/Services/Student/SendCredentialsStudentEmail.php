<?php

namespace App\Http\Services\Student;

use App\Mail\CredentialsStudent;
use Illuminate\Support\Facades\Mail;

use App\Models\Student;

class SendEmailWelcomeService
{
    public function handle()
    {
        $students = Student::query()->all();

        foreach ($students as $student) {

            Mail::to($student->email)->send(new CredentialsStudent($student->name, $student->email, $student->password));
        }
    }
}
