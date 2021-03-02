<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes_agendamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('situacao', 1); // A - Aberto | C - Confirmado | F - Finalizado | T - Falta
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->boolean('allDay')->default(false);
            $table->text('observacao')->nullable();

            // Guia
            $table->integer('movimentacao_guia_id')->unsigned()->nullable();
            $table->foreign('movimentacao_guia_id')->references('id')->on('movimentacoes_guias');

            // Profissional Procedimentos
            $table->integer('profissional_id')->unsigned()->nullable();
            $table->foreign('profissional_id')->references('id')->on('users');

            // Paciente Procedimentos
            $table->integer('paciente_id')->unsigned()->nullable();
            $table->foreign('paciente_id')->references('id')->on('users');

            // Sala
            $table->integer('sala_id')->unsigned()->nullable();
            $table->foreign('sala_id')->references('id')->on('salas');

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
        Schema::dropIfExists('movimentacoes_agendamentos');
    }
}
