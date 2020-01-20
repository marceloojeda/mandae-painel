<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TabelaDependentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('estabelecimento_id')->nullable();
            $table->unsignedBigInteger('responsavel_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nome');
            $table->string('serie')->nullable();
            $table->string('telefone', 20);
            $table->string('imagem')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('senha')->nullable();
            $table->boolean('ativo');

            $table->timestamps();

            $table->foreign('responsavel_id')->references('id')->on('responsaveis');
            $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(array('responsavel_id', 'telefone'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dependentes');
    }
}
