<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->float('valor');
            $table->float('taxa_cartao');
            $table->dateTime('data');
            $table->integer('movimentacao_id')->unsigned();
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes');
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
        Schema::dropIfExists('pagamentos');
    }
}
