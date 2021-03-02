<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelacaoPermissoesGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacao_permissoes_grupos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('grupo_id')->unsigned()->nullable();
            $table->foreign('grupo_id')->references('id')->on('grupo_permissoes');

            $table->integer('permissao_id')->unsigned()->nullable();
            $table->foreign('permissao_id')->references('id')->on('permissoes');

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
        Schema::dropIfExists('relacao_permissoes_grupos');
    }
}
