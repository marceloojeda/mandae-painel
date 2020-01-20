<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<EOF
        select
        ped.id as idPedido, ped.numero_pedido as pedido, ped.total, ped.updated_at as data, ped.status
        ,dep.nome as aluno, dep.serie, dep.estabelecimento_id as idEstabelecimento
        from pedidos ped
        join contas co on ped.conta_id = co.id
        join dependentes dep on co.dependente_id = dep.id
        order by ped.id desc
EOF;
        DB::statement(sprintf('CREATE VIEW pedidosView AS %s', $sql));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW pedidosView");
    }
}
