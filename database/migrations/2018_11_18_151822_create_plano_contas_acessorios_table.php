<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoContasAcessoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_contas_acessorios', function (Blueprint $table) {
            $table->increments('id');
            $table->double('juros')->default(0);
            $table->double('multa')->default(0);
            $table->double('mora')->default(0);
            $table->double('desconto')->default(0);

            // Plano de Contas
            $table->integer('plano_contas_id')->unsigned()->nullable();
            $table->foreign('plano_contas_id')->references('id')->on('plano_contas');

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
        Schema::dropIfExists('plano_contas_acessorios');
    }
}
