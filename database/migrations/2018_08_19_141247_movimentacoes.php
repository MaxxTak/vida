<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movimentacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('sentido')->nullable();


            $table->integer('tipo_id')->unsigned();

            $table->foreign('tipo_id')->references('id')->on('movimentacao_tipos');

            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');

            $table->integer('movimentacao_guia_id')->unsigned()->nullable();

            $table->integer('movimentacao_id')->unsigned()->nullable();

            $table->integer('plano_contas_id')->unsigned()->nullable();
        //    $table->foreign('plano_contas_id')->references('id')->on('plano_contas');

            $table->float('juros')->nullable();
            $table->integer('multa')->nullable();
            $table->string('descricao');
            $table->float('valor');
            $table->float('descontos')->nullable();
            $table->float('valor_total')->nullable();
            $table->integer('status')->nullable();

            $table->timestamps();

        });
        Schema::table('movimentacoes', function($table) {

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
