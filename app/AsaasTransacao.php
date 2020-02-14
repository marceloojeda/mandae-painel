<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Formatacao;
use App\User;
use Config;

class AsaasTransacao extends Model
{
    protected $table;
    protected $fillable;
    public $timestamps = false;

    public function __construct(){
    	$this->table = "asaas_transacoes";
        //$this->fillable = ['dateCreated', 'customer', 'subscription', 'telefone', 'imagem', 'ativo'];
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
}