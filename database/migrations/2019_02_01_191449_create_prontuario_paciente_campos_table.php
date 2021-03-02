<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntuarioPacienteCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuario_paciente_campos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sequencial');
            $table->string('campo');
            $table->string('descricao');
            $table->string('valor');

            // Prontuario Paciente
            $table->integer('prontuario_paciente_id')->unsigned()->nullable();
            $table->foreign('prontuario_paciente_id')->references('id')->on('prontuario_pacientes');


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
        Schema::dropIfExists('prontuario_paciente_campos');
    }
}
