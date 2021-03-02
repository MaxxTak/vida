<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes_guias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('situacao', 1); // A - Aberta | P - Parcial | F - Fechada
            $table->string('valor_total')->default(0);
            $table->string('valor_repasse')->default(0);
            $table->string('plano_tipo')->nullable(); // C - Conveniado | P - Particular

            // Paciente Procedimentos
            $table->integer('profissional_id')->unsigned()->nullable();
            $table->foreign('profissional_id')->references('id')->on('users');

            // Paciente Procedimentos
            $table->integer('paciente_id')->unsigned()->nullable();
            $table->foreign('paciente_id')->references('id')->on('users');

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
        Schema::dropIfExists('movimentacoes_guias');
    }
}
