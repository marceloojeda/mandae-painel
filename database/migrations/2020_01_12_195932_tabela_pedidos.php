<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('estabelecimento_id');
            $table->unsignedBigInteger('conta_id');
            $table->double('total');
            $table->enum('status', ['Aberto', 'Confirmado', 'Cancelado', 'Vencido', 'Rejeitado']);
            $table->integer('numero_pedido');

            $table->foreign('conta_id')->references('id')->on('contas');
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
