<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Conta;
use App\FiltroViewModel;

class Lancamento extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "lancamentos";
    	$this->fillable = ['estabelecimento_id', 'conta_id', 'total', 'debito'];
    }

    public function confirmaCompra($idEstabelecimento, $idConta, float $total){
        $model = new Lancamento();
        $model['estabelecimento_id'] = $idEstabelecimento;
        $model['conta_id'] = $idConta;
        $model['total'] = $total;
        $model['debito'] = true;
        $model['origem'] = \Config::get('constants.ORIGEM_PEDIDO.APLICATIVO_DEPENDENTE');

        $model->save();

        Conta::atualizarSaldo($idConta, $total);
    }

    public function lancarCredito($idEstabelecimento, $idConta, float $total) {
        $model = new Lancamento();
        $model['estabelecimento_id'] = $idEstabelecimento;
        $model['conta_id'] = $idConta;
        $model['total'] = $total;
        $model['debito'] = false;
        $model['origem'] = \Config::get('constants.ORIGEM_PEDIDO.PORTAL_RESPONSAVEL');

        $model->save();

        Conta::atualizarSaldo($idConta, $total, false);
    }

    public function extrato(FiltroViewModel $filtro) {

        $query = DB::table('lancamentos')
            ->where('estabelecimento_id', $filtro->idEstabelecimento);

        $query->orderBy('id', 'desc');

        return $query->paginate();
    }
}