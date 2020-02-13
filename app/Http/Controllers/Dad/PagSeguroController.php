<?php

namespace App\Http\Controllers\Dad;

use Illuminate\Http\Request;
use App\Helpers\Formatacao;
use App\Responsavel;
use App\Estabelecimento;
use App\Dependente;

class PagSeguroController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
    }

    public function gerarTransacao(Request $request){

        $arrHeaders = ['access_token' => $request->token];
        
        $strBody = '{"name": "João Paulo Pretti","cpfCnpj": null,"email": "pai@teste.com","phone": "34999603011","mobilePhone": "","addressNumber": null,"complement": null,"postalCode": null,"externalReference": 1}';
        
        $response = Formatacao::sendRequest('POST', $request->url, $strBody, $arrHeaders);

        return response($response);
    }
}
