<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstornosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estornos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pagamentos_id')->unsigned();
            $table->foreign('pagamentos_id')->references('id')->on('pagamentos');
            $table->integer('movimentacao_id')->unsigned();
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes');
            $table->text('motivo_estorno');
            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->double('valor');
            $table->dateTime('data_estorno');
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
        Schema::dropIfExists('estornos');
    }
}
