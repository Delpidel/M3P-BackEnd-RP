<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEvaluationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $studentName;
    public $avaliationDate;
    public $pdf;


    public function __construct($studentName, $avaliationDate)
    {
        $this->studentName = $studentName;
        $this->avaliationDate = $avaliationDate;
        // $this->pdf = $pdf;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sua avaliação está pronta!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'mails.EvaluationTemplate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromData($this->pdf -> output())
        ];
    }
}
