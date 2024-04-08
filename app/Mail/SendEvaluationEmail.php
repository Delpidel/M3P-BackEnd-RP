<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEvaluationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $studentName;
    public $avaliationDate;
    public $avaliationAge;
    public $avaliationWeight;
    public $avaliationHeight;
    public $avaliationTorax;
    public $avaliationBraco_direito;
    public $avaliationBraco_esquerdo;
    public $avaliationCintura;
    public $avaliationAntebraco_direito;
    public $avaliationAntebraco_esquerdo;
    public $avaliationAbdomen;
    public $avaliationCoxa_direita;
    public $avaliationCoxa_esquerda;
    public $avaliationQuadril;
    public $avaliationPanturrilha_direita;
    public $avaliationPanturrilha_esquerda;
    public $avaliationPunho;
    public $avaliationBiceps_femoral_direito;
    public $avaliationBiceps_femoral_esquerdo;



    public function __construct($studentName, $avaliationDate, $avaliationAge, $avaliationWeight,
                                $avaliationHeight, $avaliationTorax, $avaliationBraco_direito,
                                $avaliationBraco_esquerdo, $avaliationCintura, $avaliationAntebraco_direito,
                                $avaliationAntebraco_esquerdo, $avaliationAbdomen, $avaliationCoxa_direita,
                                $avaliationCoxa_esquerda, $avaliationQuadril, $avaliationPanturrilha_direita,
                                $avaliationPanturrilha_esquerda, $avaliationPunho,
                                $avaliationBiceps_femoral_direito,
                                $avaliationBiceps_femoral_esquerdo)
    {
        $this->studentName = $studentName;
        $this->avaliationDate = $avaliationDate;
        $this->avaliationAge = $avaliationAge;
        $this->avaliationWeight = $avaliationWeight;
        $this->avaliationHeight = $avaliationHeight;
        $this->avaliationTorax = $avaliationTorax;
        $this->avaliationBraco_direito = $avaliationBraco_direito;
        $this->avaliationBraco_esquerdo = $avaliationBraco_esquerdo;
        $this->avaliationCintura = $avaliationCintura;
        $this->avaliationAntebraco_direito = $avaliationAntebraco_direito;
        $this->avaliationAntebraco_esquerdo = $avaliationAntebraco_esquerdo;
        $this->avaliationAbdomen = $avaliationAbdomen;
        $this->avaliationCoxa_direita = $avaliationCoxa_direita;
        $this->avaliationCoxa_esquerda = $avaliationCoxa_esquerda;
        $this->avaliationQuadril = $avaliationQuadril;
        $this->avaliationPanturrilha_direita = $avaliationPanturrilha_direita;
        $this->avaliationPanturrilha_esquerda = $avaliationPanturrilha_esquerda;
        $this->avaliationPunho = $avaliationPunho;
        $this->avaliationBiceps_femoral_esquerdo = $avaliationBiceps_femoral_esquerdo;
        $this->avaliationBiceps_femoral_direito = $avaliationBiceps_femoral_direito;

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
        ];
    }
}
