<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaTabelaAsaasTransacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asaas_transacoes', function (Blueprint $table) {
            $table->string('id');
            $table->date('dateCreated');
            $table->string('customer');
            $table->string('subscription')->nullable();
            $table->string('installment')->nullable();
            $table->string('dueDate');
            $table->double('value');
            $table->double('netValue')->nullable();
            $table->enum('billingType', ['BOLETO', 'CREDIT_CARD', 'UNDEFINED']);
            $table->enum('status', ['PENDING', 'CONFIRMED', 'RECEIVED', 'RECEIVED_IN_CASH', 'OVERDUE', 'REFUND_REQUESTED', 'REFUNDED', 'CHARGEBACK_REQUESTED', 'CHARGEBACK_DISPUTE', 'AWAITING_CHARGEBACK_REVERSAL', 'DUNNING_REQUESTED', 'DUNNING_RECEIVED', 'AWAITING_RISK_ANALYSIS'])->nullable();
            $table->string('description')->nullable();
            $table->string('externalReference')->nullable();
            $table->date('originalDueDate')->nullable();
            $table->double('originalValue')->nullable();
            $table->double('interestValue')->nullable();
            $table->dateTime('confirmedDate')->nullable();
            $table->dateTime('paymentDate')->nullable();
            $table->dateTime('clientPaymentDate')->nullable();
            $table->dateTime('lastInvoiceViewedDate')->nullable();
            $table->dateTime('lastBankSlipViewedDate')->nullable();
            $table->string('invoiceUrl')->nullable();
            $table->string('bankSlipUrl')->nullable();
            $table->string('invoiceNumber')->nullable();
            $table->boolean('deleted')->nullable();
            $table->boolean('postalService')->nullable();
            $table->boolean('anticipated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asaas_transacoes');
    }
}
