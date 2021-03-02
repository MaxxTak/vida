<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagamentoFormaPagamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pagamento_forma_pagamento', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('forma_pagamento_id')->unsigned();
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento');

            $table->integer('pagamento_id')->unsigned();
            $table->foreign('pagamento_id')->references('id')->on('pagamentos');

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
        //
    }
}
