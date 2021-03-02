<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProntuarioPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prontuario_pacientes', function (Blueprint $table) {
            $table->increments('id');

            // Paciente
            $table->integer('paciente_id')->unsigned();
            $table->foreign('paciente_id')->references('id')->on('users');

            // Profissional
            $table->integer('profissional_id')->unsigned();
            $table->foreign('profissional_id')->references('id')->on('users');

            // Prontuário
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
        Schema::dropIfExists('prontuario_pacientes');
    }
}
