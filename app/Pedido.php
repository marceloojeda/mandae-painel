<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Estabelecimento;
use Config;
use App\Helpers\Formatacao;

class Pedido extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "pedidos";
    	$this->fillable = ['estabelecimento_id', 'conta_id', 'total', 'status', 'numero_pedido'];
    }

    public function conta()
    {
        return $this->hasOne('App\Conta', 'id', 'conta_id');
    }

    public function itens()
    {
        return $this->hasMany('App\PedidoItem', 'pedido_id', 'id');
    }

    public function listarPedidosAbertos($idEstabelecimento){

        $dataAtual = date('Y-m-d 00:00:00');
        return \DB::table('pedidosView')
            ->where('idEstabelecimento', $idEstabelecimento)
            ->where('status', \Config::get('constants.STATUS_PEDIDO.ABERTO'))
            ->where('data', '>=', $dataAtual)
            ->get();
    }

    public function listarPedidosConfirmados($idEstabelecimento){
        return \DB::table('pedidosView')
            ->where('idEstabelecimento', $idEstabelecimento)
            ->where('status', \Config::get('constants.STATUS_PEDIDO.CONFIRMADO'))
            ->get();
    }

    public function getByNumero($numero){
        return Pedido::where('numero_pedido', $numero)->firstOrFail();
    }

    public function getById($id){
        return Pedido::where('id', $id)->firstOrFail();
    }

    public function atualizarStatus($id, string $status){
        $model = Pedido::where('id', $id)->firstOrFail();

        $model->status = $status;

        $model->save();
    }

    public function validarConfirmacao($id) {
        $pedido = $this->getById($id);

        $dataAtual = date('Y-m-d 00:00:00');
        if($dataAtual > $pedido->created_at) {
            return "Pedido vencido";
        }

        if($pedido->total > $pedido->conta->saldo) {
            return sprintf("Saldo atual (R$ %s), insuficiente para confirmar esse pedido.", Formatacao::formataNumero($pedido->conta->saldo));
        }

        return '';
    }
}