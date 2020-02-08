<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsaasTabelaResponsavel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responsaveis', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('rua', 150)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('cidade', 150)->nullable();
            $table->char('uf', 2)->nullable();
            $table->string('cep', 10)->nullable();
            $table->boolean('notificacao')->nullable();
            $table->string('emails_adicionais')->nullable();
            $table->string('perfil', 50)->nullable();

            $table->string('asaas_customer_id', 50)->nullable();
            $table->dateTime('asaas_data_cadastro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responsaveis', function (Blueprint $table) {
            $table->dropColumn([
                'cpf',
                'celular',
                'rua',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'uf',
                'cep',
                'notificacao',
                'emails_adicionais',
                'perfil',
                'asaas_customer_id',
                'asaas_data_cadastro'
            ]);
        });
    }
}
