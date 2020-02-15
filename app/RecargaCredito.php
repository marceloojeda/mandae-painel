<?php

namespace App;

use App\Helpers\Formatacao;
use Illuminate\Database\Eloquent\Model;

class RecargaCredito extends Model
{
    protected $table;
    protected $fillable;
    public $timestamps = false;
    private $arrStatusPagamento;

    public function __construct(){
    	$this->table = "recargas_credito";
        //$this->fillable = ['dateCreated', 'customer', 'subscription', 'telefone', 'imagem', 'ativo'];
    }


    public function cadastrar($idEstabelecimento, $idResponsavel, $idDependente, $asaasModel, $taxa, $faturado = false) {

        $model = new RecargaCredito();
        $model->estabelecimento_id = $idEstabelecimento;
        $model->responsavel_id = $idResponsavel;
        $model->dependente_id = $idDependente;
        $model->valor_credito = $asaasModel->value;
        $model->valor_taxa = $taxa;
        $model->faturado = $faturado;
        $model->transacao_id = $asaasModel->id;

        if($faturado) {

            $model->data_baixa = Formatacao::dataAtual('Y-m-d H:i:s');
        }

        $model->save();

        return $model->id;
    }

    public function confirmarRecarga($idTransacao) {

        $model = $this->getByTransacaoId($idTransacao);

        if(!$model) {
            return sprintf("Registro de recarga de crédito, com idTransacao = %s, não encontrado.", $idTransacao);
        }

        $model->faturado = true;
        $model->data_baixa = Formatacao::dataAtual('Y-m-d H:i:s');

        $model->save();

        return '';
    }

    public function getByTransacaoId($idTransacao) {
        return RecargaCredito::where('transacao_id', $idTransacao)->first();
    }
}