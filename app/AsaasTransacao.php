<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AsaasTransacao extends Model
{
    protected $table;
    protected $fillable;
    public $timestamps = false;
    private $arrStatusPagamento;

    public function __construct(){
    	$this->table = "asaas_transacoes";
        //$this->fillable = ['dateCreated', 'customer', 'subscription', 'telefone', 'imagem', 'ativo'];

        $this->arrStatusPagamento = ['RECEIVED','CONFIRMED','RECEIVED_IN_CASH'];
    }

    public function getTransacoes(Request $request) {

        $sql = <<<EOF
        select
        re.nome as responsavel
        ,tr.value as valor_bruto, tr.value - tr.netValue as taxa_asaas, tr.netValue as valor_liquido
        ,tr.status, tr.dateCreated, tr.paymentDate
        from asaas_transacoes tr 
        join responsaveis re on tr.customer = re.asaas_customer_id
        -- left join lancamentos lc on lc.transacao_id = tr.id
        order by tr.dateCreated desc
EOF;
    }


    public function cadastrar($objeto) {
        
        $model = new AsaasTransacao();

        $model->id = $objeto->id;
        $model->dateCreated = $objeto->dateCreated;
        $model->customer = $objeto->customer;
        $model->dueDate = $objeto->dueDate;
        $model->value = $objeto->value;
        $model->netValue = !empty($objeto->netValue) ? $objeto->netValue : null;
        $model->billingType = $objeto->billingType;
        $model->status = !empty($objeto->status) ? $objeto->status : null;
        $model->description = !empty($objeto->description) ? $objeto->description : null;
        $model->externalReference = !empty($objeto->externalReference) ? $objeto->externalReference : null;
        $model->subscription = !empty($objeto->subscription) ? $objeto->subscription : null;
        $model->installment = !empty($objeto->installment) ? $objeto->installment : null;
        $model->originalDueDate = !empty($objeto->originalDueDate) ? $objeto->originalDueDate : null;
        $model->originalValue = !empty($objeto->originalValue) ? $objeto->originalValue : null;
        $model->interestValue = !empty($objeto->interestValue) ? $objeto->interestValue : null;
        $model->confirmedDate = !empty($objeto->confirmedDate) ? $objeto->confirmedDate : null;
        $model->paymentDate = !empty($objeto->paymentDate) ? $objeto->paymentDate : null;
        $model->clientPaymentDate = !empty($objeto->clientPaymentDate) ? $objeto->clientPaymentDate : null;
        $model->lastInvoiceViewedDate = !empty($objeto->lastInvoiceViewedDate) ? $objeto->lastInvoiceViewedDate : null;
        $model->lastBankSlipViewedDate = !empty($objeto->lastBankSlipViewedDate) ? $objeto->lastBankSlipViewedDate : null;
        $model->invoiceUrl = !empty($objeto->invoiceUrl) ? $objeto->invoiceUrl : null;
        $model->bankSlipUrl = !empty($objeto->bankSlipUrl) ? $objeto->bankSlipUrl : null;
        $model->invoiceNumber = !empty($objeto->invoiceNumber) ? $objeto->invoiceNumber : null;
        $model->deleted = !empty($objeto->deleted) ? $objeto->deleted : null;
        $model->postalService = !empty($objeto->postalService) ? $objeto->postalService : null;
        $model->anticipated = !empty($objeto->anticipated) ? $objeto->anticipated : null;
        
        $model->save();
    }

    public function getById(string $id) {

        return AsaasTransacao::where('id', $id)->first();
    }

    public function atualizar($request) {

        if(empty($request->payment)) {

            return "Notificação não contém objeto do tipo payment";
        }

        $objeto = $request->payment;

        if(empty($objeto->id)){
            return "Parametro id esperado";
        }

        $model = $this->getById($objeto->id);

        if(!$model) {
            return "Cobrança não encontrada";
        }

        $model->status = $objeto->status;

        if(in_array($objeto->status, $this->arrStatusPagamento)) {

            $model->netValue = $objeto->netValue;

            if(!empty($objeto->originalDueDate)) $model->originalDueDate = $objeto->originalDueDate;
            if(!empty($objeto->originalValue)) $model->originalValue = $objeto->originalValue;
            if(!empty($objeto->confirmedDate)) $model->confirmedDate = $objeto->confirmedDate;
            if(!empty($objeto->paymentDate)) $model->paymentDate = $objeto->paymentDate;
            if(!empty($objeto->clientPaymentDate)) $model->clientPaymentDate = $objeto->clientPaymentDate;
        }
        
        $model->save();

        return "";
    }
}