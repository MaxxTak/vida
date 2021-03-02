<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->string('documento')->nullable();
            $table->string('comp')->nullable();
            $table->string('banco')->nullable();
            $table->string('cooperativa')->nullable();
            $table->string('conta')->nullable();
            $table->string('numero')->nullable();
            $table->float('valor')->nullable();
            $table->date('data')->nullable();
            $table->smallInteger('status')->nullable();
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
        Schema::dropIfExists('cheques');
    }
}
