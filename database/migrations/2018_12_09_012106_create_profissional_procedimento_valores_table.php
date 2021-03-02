<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfissionalProcedimentoValoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissional_procedimento_valores', function (Blueprint $table) {
            $table->increments('id');

            // Valores
            $table->double('valor');
            $table->double('valor_particular');
            $table->double('valor_repasse');
            $table->double('percentual_repasse');

            // Profissional Procedimentos
            $table->integer('profissional_proc_id')->unsigned()->nullable();
            $table->foreign('profissional_proc_id')->references('id')->on('profissional_procedimentos');

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
        Schema::dropIfExists('profissional_procedimento_valores');
    }
}
