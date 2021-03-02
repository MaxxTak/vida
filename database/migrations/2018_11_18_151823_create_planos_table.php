<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->integer('dependentes');
            
            // Quantidade de vezes que cobra na entrada
            $table->integer('entrada');
            
            // Quantidade de parcelas a ser gerado o contrato
            $table->integer('meses_contrato');

            // Tabela auxiliar pra controlar histório de variação de preço.
            $table->double('valor');
            
            $table->double('adicional_dependente');

            // Plano empresarial
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // Plano Contas
            $table->integer('plano_contas_id')->unsigned();
            $table->foreign('plano_contas_id')->references('id')->on('plano_contas');

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
        Schema::dropIfExists('planos');
    }
}
