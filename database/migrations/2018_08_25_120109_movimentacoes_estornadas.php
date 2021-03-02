<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovimentacoesEstornadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('movimentacoes_estornadas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('movimentacao_id')->unsigned();
            $table->foreign('movimentacao_id')->references('id')->on('movimentacoes');
            $table->integer('movimentacao_id_estornada')->unsigned()->nullable();
            $table->foreign('movimentacao_id_estornada')->references('id')->on('movimentacoes');
            $table->text('motivo_estorno');
            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->char('sentido_cc');
            $table->integer('num_parcelas');
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
        //
    }
}
