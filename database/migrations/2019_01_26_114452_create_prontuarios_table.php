<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuarios', function (Blueprint $table) {
            $table->increments('id');

            $table->string('descricao');

            // Especialidade
            $table->integer('especialidade_id')->unsigned()->nullable();
            $table->foreign('especialidade_id')->references('id')->on('especialidades');

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
        Schema::dropIfExists('prontuarios');
    }
}
