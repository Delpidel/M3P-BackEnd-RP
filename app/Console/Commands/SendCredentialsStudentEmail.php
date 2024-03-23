<?php

namespace App\Console\Commands;

use App\Mail\CredentialsStudent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Models\Student;
use Illuminate\Support\Str;

class SendCredentialsStudentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-credentials-to-student-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um email com os as credencias de acesso do estudante';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = Student::query()->all();

        foreach ($students as $student) {

            Mail::to($student->email)->send(new CredentialsStudent($student->name, $student->email, $student->password));
        }
    }
}
