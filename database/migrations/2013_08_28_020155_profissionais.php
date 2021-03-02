<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profissionais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissionais', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('RG');
            $table->string('cargo');
            $table->date('data_nascimento')->nullable();
            $table->string('registro');
            $table->text('observacao');

              // Especialidades. Por exemplo dentista, tem um prontuário diferente do médico.

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
        Schema::dropIfExists('profissionais');
    }
}
