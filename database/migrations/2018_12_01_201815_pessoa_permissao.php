<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PessoaPermissao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pessoa_permissao', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('permissao_id')->unsigned();
            $table->foreign('permissao_id')->references('id')->on('permissoes');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');


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
        //
        Schema::dropIfExists('pessoa_permissao');
    }
}
