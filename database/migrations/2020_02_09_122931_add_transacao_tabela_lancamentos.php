<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransacaoTabelaLancamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            $table->string('gateway_pagamento')->nullable();
            $table->string('transacao_id', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lancamentos', function (Blueprint $table) {
            $table->dropColumn(['gateway_pagamento', 'transacao_id']);
        });
    }
}
