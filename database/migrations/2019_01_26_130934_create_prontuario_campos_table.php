<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntuarioCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuario_campos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sequencial');
            $table->string('campo');
            $table->string('descricao');

            // Especialidade
            $table->integer('prontuario_id')->unsigned()->nullable();
            $table->foreign('prontuario_id')->references('id')->on('prontuarios');

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
        Schema::dropIfExists('prontuario_campos');
    }
}
