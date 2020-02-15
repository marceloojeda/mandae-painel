<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaRecargasCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recargas_credito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estabelecimento_id');
            $table->unsignedBigInteger('responsavel_id');
            $table->unsignedBigInteger('dependente_id');
            $table->double('valor_credito');
            $table->double('valor_taxa');
            $table->boolean('faturado');
            $table->dateTime('data_baixa')->nullable();
            $table->string('transacao_id')->nullable();
            
            $table->foreign('responsavel_id')->references('id')->on('responsaveis');
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');
            $table->foreign('dependente_id')->references('id')->on('dependentes');

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
        Schema::dropIfExists('recargas_credito');
    }
}
