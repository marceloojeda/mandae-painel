<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaLancamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Campo origem deve ser formado por um enumerado

        Schema::create('lancamentos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('estabelecimento_id')->nullable();
            $table->unsignedBigInteger('conta_id');
            $table->double('total');
            $table->boolean('debito');
            $table->tinyInteger('origem');

            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');
            $table->foreign('conta_id')->references('id')->on('contas');
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
        Schema::dropIfExists('lancamentos');
    }
}
