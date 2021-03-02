<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfissionalProcedimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissional_procedimentos', function (Blueprint $table) {
            $table->increments('id');

            // Valor Plano
            $table->double('valor');

            // Valor Particular - Utilizado caso paciente não tenha plano vinculado
            $table->double('valor_particular');

            $table->double('valor_repasse');
            $table->double('percentual_repasse');

            // Tempo estimado do atendimento - Auxiliar agendamento
            $table->double('tempo_atendimento');
            
            // Profissional
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // Procedimento
            $table->integer('procedimento_id')->unsigned()->nullable();
            $table->foreign('procedimento_id')->references('id')->on('procedimentos');

            // Usuário cadastro
            $table->integer('usuario_cadastro')->unsigned();
            $table->foreign('usuario_cadastro')->references('id')->on('users');

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
        Schema::dropIfExists('profissional_procedimentos');
    }
}
