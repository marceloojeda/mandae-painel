<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailCompraCredito extends Mailable
{
    use Queueable, SerializesModels;

    private $responsavelRepo;
    private $solicitacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idResponsavel, $valor, $taxa)
    {
        $this->responsavelRepo = new \App\Responsavel();

        $responsavel = $this->responsavelRepo->getById($idResponsavel);
        
        $this->solicitacao = array (
            'responsavel' => $responsavel,
            'credito' => $valor,
            'taxa' => $taxa
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $solicitacao = $this->solicitacao;
        return $this->view('mail.solicitacao-compra', compact('solicitacao'));
    }
}
