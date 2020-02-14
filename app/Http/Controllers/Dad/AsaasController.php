<?php

namespace App\Http\Controllers\Dad;

use App\Responsavel;
use App\Estabelecimento;
use App\Dependente;
use App\Helpers\Formatacao;
use Illuminate\Http\Request;

class AsaasController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
    }

    public function checkout(Request $request){

        if(empty($request->input('valor')) || empty($request->input('dependente'))) {

            return redirect('/dad/credits');
        }
        
        $valor = $request->input('valor');
        $taxa = $valor * 0.05;
        $total = $valor + $taxa;
        $dependente = $this->dependenteRepo->getById($request->input('dependente'));

        return view('dad/checkout', compact('valor', 'taxa', 'total', 'dependente'));
        
    }

    public function confirm(Request $request) {

        if(empty($request->input('valor'))) {

            return redirect('/dad/credits');
        }

        $url = env('ASAAS_URL') . '/api/v3/payments';

        $responsavel = $this->responsavelRepo->getById($this->getIdResponsavel());

        $retorno = array(
            'erro' => false,
            'menssagem' => '',
            'object' => null
        );

        if(empty($responsavel->asaas_customer_id)) {
            $this->criarCustomerAsaas($responsavel);
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

        $header = array(
            'Content-Type' => 'application/json',
            'access_token' => env('ASAAS_TOKEN')
        );

        $url = env('ASAAS_URL') . '/api/v3/customers';

        $curlResponse = Formatacao::sendRequest('POST', $url, json_encode($dados), $header);

        return $curlResponse;
    }
}