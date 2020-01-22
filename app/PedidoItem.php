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
    	$this->fillable = ['pedido_id', 'produto_id', 'valor_unitario', 'quantidade', 'total'];
    }

    public function produto()
    {
        return $this->hasOne('App\Produto', 'id', 'produto_id');
    }
}