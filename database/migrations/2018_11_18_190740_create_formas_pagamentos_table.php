<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormasPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->double('abatimento')->default(0);
            $table->double('acrescimo')->default(0);
            $table->integer('tipo')->default(0);// a vista ou a prazo
            $table->integer('n_parcelas')->default(0);
            $table->float('taxa')->default(0);// taxa por parcela
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
        Schema::dropIfExists('formas_pagamento');
    }
}
