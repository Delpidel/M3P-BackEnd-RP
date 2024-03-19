<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Mail\CredentialsStudentEmail;
use Illuminate\Support\Str;

class CredentialsEmailToStudent extends Command
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
        $students = Student::where('created_at', '>=', now()->subMinute())->get(); // Obtém os estudantes criados nos últimos 60 segundos

        foreach ($students as $student) {
            // Gera uma senha aleatória
            $password = Str::random(8);

            // Define a senha para o estudante
            $student->password = bcrypt($password);
            $student->save();

            // Envie o e-mail para o estudante com suas credenciais de acesso
            Mail::to($student->email)->send(new CredentialsStudentEmail($student, $password));

            $this->info("Email enviado para {$student->email}");
        }
    }
}
