<<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use App\Models\Student;
    use Illuminate\Mail\Mailables\Content;
    use Illuminate\Mail\Mailables\Envelope;

    class CredentialsStudentEmail extends Mailable
    {
        use Queueable, SerializesModels;

        public $student;
        public $password;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public function __construct($student, $password)
        {
            $this->student = $student;
            $this->password = $password;
        }

        /**
         * Get the message envelope.
         */
        public function envelope(): Envelope
        {
            return new Envelope(
                subject: 'Envio de credencias de acesso ao estudante',
            );
        }

        /**
         * Get the message content definition.
         */
        public function content(): Content
        {
            return new Content(
                view: 'mails.credentialsStudent',
            );
        }

        /**
         * Get the attachments for the message.
         *
         * @return array<int, \Illuminate\Mail\Mailables\Attachment>
         */
        public function attachments(): array
        {
            return [];
        }
    }
    ?>