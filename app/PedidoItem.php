<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Dependente;

class PedidoItem extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "pedido_itens";
    	// $this->fillable = ['estabelecimento_id', 'dependente_id', 'total', 'status', 'numero_pedido'];
    }

    public function produto()
    {
        return $this->hasOne('App\Produto', 'id', 'produto_id');
    }
}