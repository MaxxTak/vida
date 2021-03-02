<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->float('valor');
            $table->integer('movimentacao_id')->unsigned();
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes');
            $table->float('taxa')->nullable();
            $table->date('data_vencimento');
            $table->integer('status');
            $table->integer('pagamento_id')->unsigned()->nullable();
            $table->foreign('pagamento_id')->references('id')->on('pagamentos');

            $table->integer('fk_forma_pagamento')->unsigned()->nullable();
            $table->foreign('fk_forma_pagamento')->references('id')->on('formas_pagamento');

            $table->integer('parcela_mae_id')->unsigned()->nullable();
            $table->foreign('parcela_mae_id')->references('id')->on('parcelas');

            $table->float('valor_parcial')->nullable();

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
        Schema::dropIfExists('parcelas');
    }
}
