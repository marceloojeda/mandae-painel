<?php

namespace App\Http\Controllers\Dad;

use App\Responsavel;
use App\Estabelecimento;
use App\Dependente;
use Illuminate\Http\Request;
use PagSeguroPaymentRequest;
use PagSeguroShippingType;
use PagSeguroConfig;
use PagSeguroServiceException;

class PagSeguroController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
    }

    public function gerarTransacao(Request $request){

        if(empty($request->valor)) {

            // $this->session->flash('')
            return redirect('dad/credits');
        }

        
    }
}