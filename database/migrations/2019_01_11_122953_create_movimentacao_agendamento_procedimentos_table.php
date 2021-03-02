<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoAgendamentoProcedimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao_agendamento_procedimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('situacao', 1);

            // Agendamento
            $table->integer('movimentacao_agendamento_id')->unsigned()->unsigned();
            $table->foreign('movimentacao_agendamento_id', 'movimentacao_agendamento_id_foreign')->references('id')->on('movimentacoes_agendamentos');

            // Procedimento / Guia
            $table->integer('movimentacao_guia_procedimento_id')->unsigned();
            $table->foreign('movimentacao_guia_procedimento_id', 'movimentacao_guia_procedimento_id_foreign')->references('id')->on('movimentacao_guia_procedimentos');

            // Usuário cadastro
            $table->integer('usuario_cadastro')->unsigned();
            $table->foreign('usuario_cadastro')->references('id')->on('users');

            $table->softDeletes();
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
        Schema::dropIfExists('movimentacao_agendamento_procedimentos');
    }
}
