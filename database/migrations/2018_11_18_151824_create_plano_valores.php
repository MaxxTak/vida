<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_valores', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor');
            $table->double('adicional_dependente');
            
            // 
            $table->integer('plano_id')->unsigned()->nullable();
            $table->foreign('plano_id')->references('id')->on('planos');

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
        Schema::dropIfExists('plano_valores');
    }
}
