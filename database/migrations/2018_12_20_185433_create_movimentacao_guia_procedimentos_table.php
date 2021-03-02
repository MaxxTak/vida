<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoGuiaProcedimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao_guia_procedimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor');
            $table->double('quantidade');
            $table->double('valor_total');
            $table->double('valor_repasse');
            $table->string('alterado');
            $table->string('observacao')->nullable();

            // Status do procedimento
            $table->string('situacao', 1);  // A -> Aberto | P -> Parcial (Em Andamento) | F -> Finalizado
            
            // Paciente Procedimentos
            $table->integer('profissional_id')->unsigned()->nullable();
            $table->foreign('profissional_id')->references('id')->on('users');

            // Usuário cadastro
            $table->integer('movimentacao_guia_id')->unsigned();
            $table->foreign('movimentacao_guia_id')->references('id')->on('movimentacoes_guias');

            // Procedimento
            $table->integer('procedimento_id')->unsigned();
            $table->foreign('procedimento_id')->references('id')->on('procedimentos');

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
        Schema::dropIfExists('movimentacao_guia_procedimentos');
    }
}
