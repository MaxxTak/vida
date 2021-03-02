<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelaPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcela_pagamentos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parcela_id')->unsigned();
            $table->foreign('parcela_id')->references('id')->on('parcelas');
            $table->integer('pagamentos_id')->unsigned();
            $table->foreign('pagamentos_id')->references('id')->on('pagamentos');
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
        Schema::dropIfExists('parcela_pagamentos');
    }
}
