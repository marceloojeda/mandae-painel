<?php

namespace App\Http\Controllers\Dad;

use App\AsaasTransacao;
use App\Responsavel;
use App\Dependente;
use App\Helpers\Formatacao;
use App\Lancamento;
use App\RecargaCredito;
use Illuminate\Http\Request;

class AsaasController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;
    private $asaasTransacaoRepo;
    private $recargaCreditoRepo;
    private $lancamentoRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
        $this->asaasTransacaoRepo = new AsaasTransacao();
        $this->recargaCreditoRepo = new RecargaCredito();
        $this->lancamentoRepo = new Lancamento();
    }

    public function checkout(Request $request){

        if(empty($request->input('valor')) || empty($request->input('dependente'))) {

            return redirect('/dad/credits');
        }
        
        $valor = $request->input('valor');
        
        $taxa = 0;
        switch ($valor) {
            case 30:
                $taxa = 1.47;
                break;
            case 50:
                $taxa = 2.45;
                break;
            case 100:
                $taxa = 4.9;
                break;
            case 200:
                $taxa = 9.8;
                break;
            case 300:
                $taxa = 9.8;
                break;
            case 400:
                $taxa = 9.8;
                break;
            
            default:
                $taxa = 9.8;
                break;
        }

        $total = $valor + $taxa;
        $dependente = $this->dependenteRepo->getById($request->input('dependente'));

        return view('dad/checkout', compact('valor', 'taxa', 'total', 'dependente'));
        
    }

    public function confirm(Request $request) {

        $retorno = array(
            'erro' => false,
            'mensagem' => '',
            'object' => null
        );

        try{
            if(empty($request->input('valor'))) {

                return redirect('/dad/credits');
            }

            $responsavel = $this->responsavelRepo->getById($this->getIdResponsavel());        

            $asaasCustomerId = $responsavel->asaas_customer_id;
            if(empty($asaasCustomerId)) {

                $arrCustomer = $this->criarCustomerAsaas($responsavel);
                if($arrCustomer['erro']) {

                    $retorno['erro'] = true;
                    $retorno['mensagem'] = $arrCustomer['msg'];

                    return response()->json($retorno);
                }

                $responsavel = $this->responsavelRepo->getById($this->getIdResponsavel());
            }

            $arrCobranca = $this->criarCobranca($responsavel, $request->input('valor'), $request->input('taxa'), $request->input('formaPagto'));

            if($arrCobranca['erro']) {
                $retorno['erro'] = true;
                $retorno['mensagem'] = $arrCobranca['msg'];

                return response()->json($retorno);
            }

            $cobranca = $arrCobranca['std'];
            $this->recargaCreditoRepo->cadastrar(
                $this->getIdEstabelecimento(), 
                $this->getIdResponsavel(),
                $request->idDependente, 
                $cobranca, 
                $request->taxa
            );

            $retorno['object'] = $cobranca;
            $retorno['mensagem'] = sprintf("Transação %s gerada com sucesso", $cobranca->id);

            return response()->json($retorno);

        } catch(\Exception $e) {

            $retorno['erro'] = true;
            $retorno['mensagem'] = $e->getMessage();

            return response()->json($retorno);
        }
    }

    private function criarCustomerAsaas($responsavel) {

        $dados = array(
            "name" => $responsavel->nome,
            "cpfCnpj" => $responsavel->cpf,
            "email" => $responsavel->user->email,
            "phone" => $responsavel->telefone,
            "mobilePhone" => $responsavel->celular,
            "addressNumber" => $responsavel->numero,
            "complement" => $responsavel->complemento,
            "postalCode" => $responsavel->cep,
            "externalReference" => $responsavel->id
        );

        $arrHeader = array(
            'Content-Type: application/json',
            'access_token: ' . env('ASAAS_TOKEN')
        );
        $url = env('ASAAS_URL') . '/api/v3/customers';

        $curlResponse = Formatacao::sendRequest('POST', $url, json_encode($dados), $arrHeader);

        $asaasCustomer = $curlResponse;

        $stdAsaasCustomer = json_decode($asaasCustomer);

        $retorno = array(
            'erro' => false,
            'msg' => '',
            'id' => ''
        );

        if(!empty($stdAsaasCustomer->errors)) {
            
            $retorno['erro'] = true;
            $retorno['msg'] = $stdAsaasCustomer->errors->description;
            
            return $retorno;
        }

        $this->responsavelRepo->updateAsaasCustomer($stdAsaasCustomer->id, $responsavel->id);

        $retorno['id'] = $stdAsaasCustomer->id;

        return $retorno;
    }

    private function criarCobranca($responsavel, $valorCredito, $taxa, $formaPagamento) {

        $vencimento = date('Y-m-d', strtotime('+3 days', strtotime(Formatacao::dataAtual())));
        $dados = array(
            'customer' => $responsavel->asaas_customer_id,
            'value' => $valorCredito + $taxa,
            'dueDate' => $vencimento,
            'description' => sprintf("Compra de %s em créditos no iCantian", $valorCredito),
            'externalReference' => sprintf("Cliente: %s. Valor crédito: %s", $responsavel->nome, $valorCredito),
            'postalService' => false
        );

        switch ($formaPagamento) {
            case 'boleto':
                $dados['billingType'] = 'BOLETO';
                break;
            case 'cartao':
                $dados['billingType'] = 'CREDIT_CARD';
                break;
            default:
                $dados['billingType'] = 'CREDIT_CARD';
                break;
        }

        $arrHeader = array(
            'Content-Type: application/json',
            'access_token: ' . env('ASAAS_TOKEN')
        );
        $url = env('ASAAS_URL') . '/api/v3/payments';

        $curlResponse = Formatacao::sendRequest('POST', $url, json_encode($dados), $arrHeader);

        $asaasPayment = $curlResponse;

        $stdAsaasPayment = json_decode($asaasPayment);

        $retorno = array(
            'erro' => false,
            'msg' => '',
            'std' => null
        );

        if(!empty($stdAsaasPayment->errors)) {
            
            $retorno['erro'] = true;
            $retorno['msg'] = $stdAsaasPayment->errors->description;
            
            return $retorno;
        }

        $this->asaasTransacaoRepo->cadastrar($stdAsaasPayment);

        $retorno['std'] = $stdAsaasPayment;
        return $retorno;
    }

    public function notificacao(Request $request){

        $retorno = array(
            'erro' => false,
            'mensagem' => ''
        );

        try {

            if(!empty($msg = $this->asaasTransacaoRepo->atualizar($request))) {

                $retorno['erro'] = true;
                $retorno['mensagem'] = $msg;

                return response()->json($retorno);
            }

            if(!$recargaCredito = $this->recargaCreditoRepo->getByTransacaoId($request->payment['id'])) {

                $retorno['erro'] = true;
                $retorno['mensagem'] = sprintf("Nenhuma recarga de crédito com transacao_id = %s foi encontrado.", $request->id);

                return response()->json($retorno);
            }

            if(!empty($erroFaturar = $this->recargaCreditoRepo->confirmarRecarga($request->payment['id']))) {
                $retorno['erro'] = true;
                $retorno['mensagem'] = $erroFaturar;

                return response()->json($retorno);
            }

            $arrStatusPagamento = ['RECEIVED','CONFIRMED','RECEIVED_IN_CASH'];
            if(in_array($request->payment['status'], $arrStatusPagamento)) {

                $dependente = $this->dependenteRepo->getById($recargaCredito->dependente_id);

                $this->lancamentoRepo->lancarCredito(
                    $dependente->estabelecimento_id, 
                    $dependente->conta->id,
                    $recargaCredito->valor_credito);
            }

            $retorno['mensagem'] = "Transação atualizada com sucesso";

            return response()->json($retorno);

        } catch(\Exception $e) {

            $retorno['erro'] = true;
            $retorno['mensagem'] = $e->getMessage();
            $retorno['trace'] = $e->getTraceAsString();

            return response()->json($retorno);
        }

    }

}