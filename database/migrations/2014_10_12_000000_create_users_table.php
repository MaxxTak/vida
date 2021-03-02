<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cnpjcpf', 14)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nim')->nullable();
            $table->string('telefone',20)->nullable();
            $table->integer('ordem')->nullable();
            $table->smallInteger('status')->nullable()->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();

            $table->integer('empresa_id')->unsigned()->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->integer('paciente_id')->unsigned()->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes');

            $table->integer('profissional_id')->unsigned()->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionais');

            // Qual o titular do plano. Significa que essa pessoa é dependente do titular.
            $table->integer('titular_id')->unsigned()->nullable();
            $table->foreign('titular_id')->references('id')->on('users');

            $table->integer('role')->default(0)->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
